package nolp.lms.controller.cms.testbank;

import java.text.ParseException;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import java.util.Locale;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.log4j.Logger;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.donjai.util.UtilDateTime;

import nolp.lms.controller.Controller;
import nolp.lms.dao.ClsClassPropertiesDao;
import nolp.lms.dao.ClsSectionDao;
import nolp.lms.dao.ClsSectionPropertiesDao;
import nolp.lms.dao.cms.testbank.QuestionModelDao;
import nolp.lms.dao.cms.testbank.TestResultDao;
import nolp.lms.model.AccGroup;
import nolp.lms.model.ClsClassProperties;
import nolp.lms.model.ClsSection;
import nolp.lms.model.ClsSectionProperties;
import nolp.lms.model.cms.testbank.QuestionModel;
import nolp.lms.model.cms.testbank.TestResult;
import nolp.lms.model.json.cms.testbank.QuestionModelJSON;
import nolp.lms.model.json.cms.testbank.TestResultJSON;
import nolp.lms.util.UtilString;

public class ResultTestbankAjaxController extends Controller {

	private static final Logger log = Logger.getLogger(ResultTestbankAjaxController.class);
	private static final long serialVersionUID = 239399876693019296L;
	
	private TestResultDao testresultDao;
	private QuestionModelDao qmodelDao;
	
	private ClsSectionDao sectionDao;
	private ClsSectionPropertiesDao sectionpropDao;
	private ClsClassPropertiesDao classpropDao;
	
	private TestBankService tbservice;

	public ResultTestbankAjaxController(HttpServletRequest req, HttpServletResponse res) {
		super(req, res);
	}

	@Override
	protected void initDao() {
		testresultDao = new TestResultDao();
		qmodelDao = new QuestionModelDao();
		sectionDao = new ClsSectionDao();
		sectionpropDao = new ClsSectionPropertiesDao();
		classpropDao = new ClsClassPropertiesDao();
		
		tbservice = new TestBankService();
	}

	@Override
	protected void initParameter() {
		putAllParameter();
	}

	@Override
	protected void execute() {
		int res_status = 500;
		String msg = "";
		checkSession();
		if(hasSession()){
			if(hasLevelPermission(new Integer[]{AccGroup.GROUP_LEVEL_ADMINISTRATOR})){
				if(validParameterAllRequire(new String[]{"sectionid"})){
					Integer sectionid = UtilString.toInt(getData("sectionid"));
					if(sectionid != null && sectionid.intValue() > 0){
						ClsSection section = (ClsSection) sectionDao.get(sectionid.intValue());
						if(section != null){
							if(section.getStatus() == ClsSection.STATUS_ACTIVE){
								String expiredate = section.getExpiredate();
								boolean isExpire = false;
								if(expiredate != null){
									try {
										Date d = UtilDateTime.toDate_6(expiredate);
										Date now = Calendar.getInstance(Locale.US).getTime();
										if(now.getTime() > d.getTime()){
											isExpire = true;
										}
									} catch (ParseException e) {
										log.error(e);
									}
								}else{
									isExpire = true;
								}
								
								if(isExpire){
									ClsClassProperties classprop = (ClsClassProperties) classpropDao.findWithClassidPropname(section.getClassid(),ClsClassProperties.PROPNAME_LEARNING_TYPE);
									if(classprop != null && classprop.getPropvalue() != null && classprop.getPropvalue().equals(ClsClassProperties.PROPVALUE_LEARNING_TYPE_TESTBANK)){
										ClsSectionProperties secProp = (ClsSectionProperties) sectionpropDao.findWithSectionidPropname(section.getSectionid(),ClsSectionProperties.PROPNAME_HRID);
										
										if(secProp != null){
											int hrid = UtilString.toInt(secProp.getPropvalue(), 0);
											if(hrid > 0 ){
												
												if( section.getSectionid() > 0 )){
													List<TestResult> listResults = testresultDao.findClassSectionHridActive(section.getClassid(), section.getSectionid(), hrid);
													if(listResults != null && listResults.size() > 0 ){
														boolean dataReady = true;
														JSONArray result = new JSONArray();
														for(TestResult tr : listResults){
															List<QuestionModel> listQm = qmodelDao.findWithCtbtrid(tr.getCtbtrid());
															if(listQm != null && listQm.size() > 0 ){
																JSONObject jobj = TestResultJSON.toJSON(tr);
																if(jobj != null){
																	JSONArray qmAr = QuestionModelJSON.toJSONArray(listQm);
																	if(qmAr != null){
																		try {
																			jobj.put("questionmodel", qmAr);
																			result.put(jobj);
																		} catch (JSONException e) {
																			log.error(e);
																		}
																	}else{
																		dataReady = false;
																		break;
																	}
																}else{
																	dataReady = false;
																	break;
																}
															}else{
																dataReady = false;
																break;
															}
															
														}
														
														if(dataReady){
															res_status = 200;
															msg = "complete";
															
															JSONObject jsonObj = new JSONObject();
															try {
																jsonObj.put("sectionid",sectionid);
																jsonObj.put("data", result);
															} catch (JSONException e) {
																log.error(e);
															}
															
															// send json over http to TestBank App
															res_status = tbservice.postResultData(jsonObj.toString());
															if(res_status == 200){
																ClsSectionProperties sp = (ClsSectionProperties) sectionpropDao.findWithSectionidPropname(section.getSectionid(), ClsSectionProperties.PROPNAME_FLAG_CLOSE);
																if(sp == null){
																	sp = new ClsSectionProperties();
																	sp.setSectionid(section.getSectionid());
																	sp.setPropname(ClsSectionProperties.PROPNAME_FLAG_CLOSE);
																	sp.setPropvalue(ClsSectionProperties.PROPVALUE_FLAG_CLOSE);
																	sectionpropDao.insert(sp);
																}else{
																	sp.setPropvalue(ClsSectionProperties.PROPVALUE_FLAG_CLOSE);
																	sectionpropDao.update(sp);
																}
															}else{
																log.debug("Update result to TestBank fail.");
															}
															
															
														}else{
															msg = "Data is not ready..";
															log.debug(msg);
														}
														
													}else{
														msg = "Result is empty.";
														log.debug(msg);
													}
												}else{
													res_status = 206;
													msg = "TestResult is not ready.";
													log.debug(msg);
												}
												
											}else{
												msg = "Error hrid.";
												log.debug(msg);
											}
										}else{
											msg = "Not found Question suite.";
											log.debug(msg);
										}
									}else{
										msg = "Not found type testbank of Course.";
										log.debug(msg);
									}	
								}else{
									res_status = 205;
									msg = "Section is not Expire.";
									log.debug(msg);
								}
								
							}else{
								msg = "Section is not active.";
								log.debug(msg);
							}
						}else{
							msg = "Not found Section.";
							log.debug(msg);
						}
					}else{
						msg = "Error parameter sectionid < 1.";
						log.debug(msg);
					}
				}else{
					msg = "Invalid parameter.";
					log.debug(msg);
				}
			}else{
				msg = "Access Denied.";
				log.debug(msg);
				throwPageAccessDenied();
			}
		}
		putData("result-msg",msg);
		putData("result-status",res_status);
		response.setStatus(res_status);
	}

	@Override
	protected void clear() {
		testresultDao = null;
		qmodelDao = null;
		sectionDao = null;
		sectionpropDao = null;
		classpropDao = null;
		
		tbservice = null;
	}

}
