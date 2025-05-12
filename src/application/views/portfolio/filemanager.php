<?php // $this->load->view("breadcrumb/breadcrumb", $breadcrumb); 
//	$data = $this->MasterDataModel->get_occ_level_seperate();
//	if(count($data) > 0){

?>

<div class="content-header">
    <h3> ตัวจัดการไฟล์
    </h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="#">หน้าแรก</a>
        </li>
		<li class="breadcrumb-item ">
            <a href="#">ชุดทดสอบเก็บถาวร</a>
        </li>

        <li class="breadcrumb-item active">
            <a href="#" style="color:red">อัพโหลดไฟล์</a>
        </li>
    </ol>
</div>
<input type="hidden" name="asm_tool" id="asm_tool" value='<?= $asm_tool_type ?>'>
<section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 px-5">
                    <div class="bg__white__screen">
                        <div class="container-fluid">
								<div class="row mt-5">
								<div class="managerflexcontainer">
								<div class="managerflexitem">
									<label class=""> คุณวุฒิวิชาชีพ</label>
									<div class="" style="padding-bottom:5px">
										<input type="hidden" class="form-control" id="txt_occ_level" name="txt_occ_level" />
										<select class="form-control occ_level" data-dropup-auto="false" id="occ_level"
											name="occ_level" required="" data-live-search="true">
									       <option value="0">--ทั้งหมด--</option>   
											<?php
											$title = "";
											foreach ($file_tier1 as $v) { 
											if($title != $v->tier1_title){?>
											<option value="<?php echo $v->tier1_title; ?>">
                                            <?php echo $v->tier1_title; ?>
											</option>
											<?php }
												$title = $v->tier1_title;
												} ?>
										</select>
									  </div>
								</div>
								<div class="managerflexitem">
									  <label class=""> สาขา</label>
										
                                        <div class="" style="padding-bottom:5px">
                                            <input type="hidden" id="txt_occ_level" name="txt_occ_level">
                                            <select class="form-control occ_level" data-dropup-auto="false"
                                                id="occ_level_id" name="occ_level_id" required=""
                                                data-live-search="true"> 
                                                <option value="0">--กรุณาเลือก--</option>   
											<?php $title = "";
											foreach ($file_tier2 as $v) { 
											if($title != $v->tier2_title){?>
											<option value="<?php echo $v->tier2_title; ?>">
                                            <?php echo $v->tier2_title; ?>
											</option>
											<?php }
												$title = $v->tier2_title;
												} ?>
                                            </select>
										
										</div>
								</div>
									<div class="managerflexitem">
										<label class=""> อาชีพ</label>
										
                                        <div class="" style="padding-bottom:5px">
                                            <input type="hidden" id="txt_occ_level" name="txt_occ_level">
                                            <select class="form-control occ_level" data-dropup-auto="false"
                                                id="occ_level_id" name="occ_level_id" required=""
                                                data-live-search="true"> 
                                                <option value="0">--กรุณาเลือก--</option>   
											<?php $title = "";
											foreach ($file_tier3 as $v) { 
											if($title != $v->tier3_title){?>
											<option value="<?php echo $v->tier3_title; ?>">
                                            <?php echo $v->tier3_title; ?>
											</option>
											<?php }
												$title = $v->tier3_title;
												} ?>
                                            </select>
											
                                        </div>
									</div>
									<div class="managerflexitem">
										<label class=""> ระดับ</label>
										
                                        <div class="" style="padding-bottom:5px">
                                            <input type="hidden" id="txt_occ_level" name="txt_occ_level">
                                            <select class="form-control occ_level" data-dropup-auto="false"
                                                id="occ_level_id" name="occ_level_id" required=""
                                                data-live-search="true"> 
                                                <option value="0">--กรุณาเลือก--</option>   
											<?php $title = "";
											foreach ($file_level as $v) {
												if($title != $v->level_name){?>
											<option value="<?php echo $v->level_name; ?>">
                                            <?php echo $v->level_name; ?>
											</option>
												<?php $title = $v->level_name; }
												
												} ?>
                                            </select>
											
                                        </div>
									</div>
								</div>
								
								</div>
                                <div class="row mt-5">
                                    
                                
                                    <div class="col-12 col-md-6 col-lg-2 mb-3">
                                    <!--    <label for="branch" class="form-label">ประเภทไฟล์</label>  -->
										<label for="branch" class="form-label">Type of File</label>
                                        <select id="branch" class="form-select">
                                            <option selected disabled>--กรุณาเลือก--</option>
                                            <option value="1">PNG</option>
                                            <option value="2">JPEG</option>
                                            <option value="3">PDF</option>
											<option value="4">jpg</option>
                                            <option value="5">jpeg</option>
                                            <option value="6">png</option>
											<option value="7">pdf</option>
											<option value="8">xls</option>
											<option value="9">csv</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-2 mb-3">
                                        <label for="date" class="form-label">วันที่นำเข้า</label>
                                        <input type="date" id="date" class="form-control">
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-2 mb-3 margin__top___date">
                                        <input type="date" id="date" class="form-control">
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-2 mb-3 margin__top___date">
                                        <button class="submit__button__style"><i class="ri-search-line"></i><input class="submit__button" type="submit" value="ค้นหา"></button>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-2 mb-3 margin__top___date ">
                                        <button type="button" class="upload__button__style" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="ri-upload-2-fill"></i> อัพโหลดไฟล์</button>
                                        <div class="modal fade" id="exampleModal" tabindex="-1" >
											
										<form action="" method="POST" name="form2">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header upload__title">
                                                  <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                                                  <button type="button" class="btn-close white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                  <div class="container-fluid">
                                                    <div class="row">
														<input type="hidden" class="form-control" id="tp_id" name="tp_id" value="<?= $_SESSION['template_id']; ?>" />
                                                        <div class="col-12 col-md-12 col-lg-12">
                                                            <label for="qualification2" class="form-label">คุณวุฒิวิชาชีพ</label>
                                                            <select id="qualification2" class="form-select">
                                                                <option selected disabled>--กรุณาเลือก--</option>
                                                                <?php
																	$title = "";
																	foreach ($file_tier1 as $v) { 
																	if($title != $v->tier1_title){?>
																	<option value="<?php echo $v->tier1_title; ?>">
																<?php echo $v->tier1_title; ?>
																</option>
																<?php }
																	$title = $v->tier1_title;
																} ?>
                                                            </select>
                                                    <div class="row">
                                                        <div class="col-12 col-md-12 col-lg-12">
                                                            <label for="branch2" class="form-label">สาขา</label>
                                                            <select id="branch2" class="form-select">
                                                                <option selected disabled>--กรุณาเลือก--</option>
                                                                <?php
																	$title = "";
																	foreach ($file_tier2 as $v) { 
																	if($title != $v->tier2_title){?>
																	<option value="<?php echo $v->tier2_title; ?>">
																<?php echo $v->tier2_title; ?>
																</option>
																<?php }
																	$title = $v->tier2_title;
																} ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-md-12 col-lg-12">
                                                            <label for="occupation2" class="form-label">อาชีพ</label>
                                                            <select id="occupation2" class="form-select">
                                                                <option selected disabled>--กรุณาเลือก--</option>
                                                                <?php
																	$title = "";
																	foreach ($file_tier3 as $v) { 
																	if($title != $v->tier3_title){?>
																	<option value="<?php echo $v->tier3_title; ?>">
																<?php echo $v->tier3_title; ?>
																</option>
																<?php }
																	$title = $v->tier3_title;
																} ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-md-12 col-lg-12">
                                                            <label for="level2" class="form-label">ระดับ</label>
                                                            <select id="level2" class="form-select">
                                                                <option selected disabled>--กรุณาเลือก--</option>
                                                                <?php $title = "";
																	foreach ($file_level as $v) {
																	if($title != $v->level_name){?>
																<option value="<?php echo $v->level_name; ?>">
																<?php echo $v->level_name; ?>
																</option>
																<?php  }
																	$title = $v->level_name;
																} ?>
                                                            </select>
                                                        </div>
                                                    </div>    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-check mt-3">
                                                                <input class="form-check-input" type="checkbox" name="exam_type_option" value="สัมภาษณ์" id="interview">
                                                                <label class="form-check-label" for="interview">
                                                                  สัมภาษณ์
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-check mt-3">
                                                                <input class="form-check-input" type="checkbox" name="exam_type_option" value="สาธิตการปฏิบัติงาน" id="show">
                                                                <label class="form-check-label" for="show">
                                                                  สาธิตการปฏิบัติงาน
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-check mt-3">
                                                                <input class="form-check-input" type="checkbox" name="exam_type_option" value="แฟ้มสะสมผลงาน" id="file">
                                                                <label class="form-check-label" for="file">
                                                                  แฟ้มสะสมผลงาน
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-check mt-3">
                                                                <input class="form-check-input" type="checkbox" name="exam_type_option" value="ประเมินด้วยบุคคลที่สาม" id="evaluate">
                                                                <label class="form-check-label" for="evaluate">
                                                                  ประเมินด้วยบุคคลที่สาม
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-check mt-3">
                                                                <input class="form-check-input" type="checkbox" name="exam_type_option" value="จำลองสถานการณ์" id="mock">
                                                                <label class="form-check-label" for="mock">
                                                                  จำลองสถานการณ์
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-check mt-3">
                                                                <input class="form-check-input" type="checkbox" name="exam_type_option" value="สังเกตการณ์ ณ หน้างานจริง" id="observe">
                                                                <label class="form-check-label" for="observe">
                                                                  สังเกตุการณ์ ณ หน้างานจริง
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="exam_type_option" value="RESK" id="resk">
                                                                <label class="form-check-label" for="resk">
                                                                  RESK
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-3">Type File</div>
                                                        <div class="col-md-3">
                                                            <div class="form-check ">
                                                                <input class="form-check-input" type="checkbox" name="file_type_option" value="ข้อเขียน" id="written">
                                                                <label class="form-check-label" for="written">
                                                                  ข้อเขียน
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check ">
                                                                <input class="form-check-input" type="checkbox" name="file_type_option" value="อัตนัย" id="written2">
                                                                <label class="form-check-label" for="written2">
                                                                  อัตนัย
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-12 mt-3">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                        <div class="col-md-12 mt-3">
                                                            <input type="text" class="form-control" placeholder="คำอธิบายไฟล์ :">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="file-upload-container" id="fileUploadContainer">
                                                                <input type="file" value="" id="fileUpload" name="fileUpload[]" multiple>
                                                                <div class="plus-icon">+</div>
                                                                <div class="upload-text">Drag, Click, or Paste File Here</div>
                                                                <div id="fileName" id="fileName" class="file-name" value="">No file selected</div>
                                                            </div>
                                                        
                                                            <script>
                                                                const fileInput = document.getElementById("fileUpload");
                                                                const fileNameDisplay = document.getElementById("fileName");
                                                                const fileUploadContainer = document.getElementById("fileUploadContainer");
                                                        
                                                                // Handle file selection via input
                                                                fileInput.addEventListener("change", handleFileSelect);
                                                        
                                                                // Handle drag-and-drop
                                                                fileUploadContainer.addEventListener("dragover", (e) => {
                                                                    e.preventDefault();
                                                                    fileUploadContainer.classList.add("active");
                                                                });
                                                        
                                                                fileUploadContainer.addEventListener("dragleave", () => {
                                                                    fileUploadContainer.classList.remove("active");
                                                                });
                                                        
                                                                fileUploadContainer.addEventListener("drop", (e) => {
                                                                    e.preventDefault();
                                                                    fileUploadContainer.classList.remove("active");
                                                                    const file = e.dataTransfer.files[0];
                                                                    if (file) {
                                                                        displayFileName(file);
                                                                    }
                                                                });
                                                        
                                                                // Handle file paste
                                                                fileUploadContainer.addEventListener("paste", (e) => {
                                                                    const items = e.clipboardData.items;
                                                                    for (let i = 0; i < items.length; i++) {
                                                                        if (items[i].kind === "file") {
                                                                            const file = items[i].getAsFile();
                                                                            if (file) {
                                                                                displayFileName(file);
                                                                            }
                                                                        }
                                                                    }
                                                                });
                                                        
                                                                // Display file name
                                                                function handleFileSelect() {
                                                                    const file = fileInput.files[0];
                                                                    if (file) {
                                                                        displayFileName(file);
                                                                    }
                                                                }
                                                        
                                                                function displayFileName(file) {
                                                                    fileNameDisplay.textContent = `File: ${file.name}`;
																	fileNameDisplay.value = file.name;
																	
                                                                }
                                                            </script>
                                                        </div>
                                                    </div>
                                                        </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                  <button type="button" class="btn btn-primary" id="upload" onclick="upload_file()">Save changes</button>
                                                </div>
                                              </div>
                                            </div>
											</form>
                                          </div>
                                    </div>
                                        

                                    </div>
                                </div>
                            <hr class="mt-3">
                           
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-8">

                                    </div>
                                    <div class="col-md-4 mb-3">
                                         <label for="search">ค้นหา</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>คุณวุฒิวิชาชีพ</th>
                                            <th>สาขา</th>
                                            <th>อาชีพ</th>
                                            <th>ระดับ</th>
                                            <th>สัมภาษณ์</th>
                                            <th>สาธิตการปฏิบัติงาน</th>
                                            <th>แฟ้มสะสมผลงาน</th>
                                            <th>ประเมินด้วยบุคคลที่สาม</th>
                                            <th>จำลองสถานการณ์</th>
                                            <th>สังเกตการณ์ ณ หน้างานจริง</th>
                                            <th>RESK</th>
                                            <th>File Name</th>
                                            <th>User Upload</th>
                                            <th>Last Update</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php if (is_array($files_list) && !empty($files_list)) { 
												$i = 1;
												echo "<tbody>";
												foreach ($files_list as $v) {
													echo "<tr>"; 
													echo "<td><input type='hidden' value='{$v->id}'>{$i}</td>"; 
													echo "<td>" . (isset($v->tier1_title) ? $v->tier1_title : 'Tier1_title not set') . "</td>"; 
													echo "<td>" . (isset($v->tier2_title) ? $v->tier2_title : 'Tier2_title not set') . "</td>"; 
													echo "<td>" . (isset($v->tier3_title) ? $v->tier3_title : 'Tier3_title not set') . "</td>"; 
													echo "<td>" . (isset($v->level_name) ? $v->level_name : 'Level Name not set') . "</td>"; 
													echo "<td>"; 
													if (isset($v->interview)) { 
														echo $v->interview == 0 ? "<i class='ri-subtract-line'></i>" : "<i class='ri-check-line check'></i>";
													} else { 
														echo "Interview not set";
													} echo "</td>"; 
													echo "<td>"; 
													if (isset($v->demonstrate_work_performance)) { 
														echo $v->demonstrate_work_performance == 0 ? "<i class='ri-subtract-line'></i>" : "<i class='ri-check-line check'></i>"; 
													} else { 
														echo "Demonstrate Work Performance not set";
													} 
													echo "</td>";
													echo "<td>";
													if (isset($v->portfolio)) {
														echo $v->portfolio == 0 ? "<i class='ri-subtract-line'></i>" : "<i class='ri-check-line check'></i>";
													} else { 
														echo "Portfolio not set"; 
													} 
													echo "</td>";
													echo "<td>";
													if (isset($v->third_party_assessment)) { 
														echo $v->third_party_assessment == 0 ? "<i class='ri-subtract-line'></i>" : "<i class='ri-check-line check'></i>";
													} else { 
														echo "Third Party Assessment not set";
													} 
													echo "</td>";
													echo "<td>";
													if (isset($v->simulate_the_situation)) {
														echo $v->simulate_the_situation == 0 ? "<i class='ri-subtract-line'></i>" : "<i class='ri-check-line check'></i>"; 
													} else { 
														echo "Simulate the Situation not set"; 
													} 
													echo "</td>";
													echo "<td>";
													if (isset($v->observe_on_site)) {
														echo $v->observe_on_site == 0 ? "<i class='ri-subtract-line'></i>" : "<i class='ri-check-line check'></i>"; 
													} else {
														echo "Observe On-site not set";
													}
													echo "</td>";
													echo "<td>";
													if (isset($v->RESK)) { 
														echo $v->RESK == 0 ? "<i class='ri-subtract-line'></i>" : "<i class='ri-check-line check'></i>"; } else { echo "RESK not set"; } echo "</td>"; echo "<td>" . (isset($v->file_name) ? $v->file_name : 'File Name not set') . "</td>"; echo "<td>" . (isset($v->user_uploaded) ? $v->user_uploaded : 'User Uploaded not set') . "</td>"; echo "<td>" . (isset($v->last_updated) ? $v->last_updated : 'Last Updated not set') . "</td>"; echo "<td class='d-flex flex-column align-items-center'> <div class='d-flex flex-row justify-content-center align-items-center'> <div class='cursor' data-bs-toggle='modal' data-bs-target='#exampleModal2'> <i class='ri-pencil-fill yellow'></i><span class='yellow me-2'>Edit</span> </div> <i class='ri-delete-bin-7-fill red'></i><span class='red'>Delete</span> </div> </td>"; echo "</tr>"; $i++; } echo "</tbody>"; // Close the table
											} else { echo "Files list is not available or empty."; } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
	<div class="modal fade" id="exampleModal2" tabindex="-1" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header upload__title">
              <h5 class="modal-title" id="exampleModalLabel">Edit File</h5>
              <button type="button" class="btn-close white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <label for="qualification3" class="form-label">คุณวุฒิวิชาชีพ</label>
                        <select disabled id="qualification3" class="form-select">
                            <option  disabled>--กรุณาเลือก--</option>
                            <option selected disabled value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <label for="branch2" class="form-label">สาขา</label>
                        <select disabled id="branch2" class="form-select">
                            <option selected disabled>--กรุณาเลือก--</option>
                            <option value="1">One</option>
                            <option selected disabled value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <label for="occupation2" class="form-label">อาชีพ</label>
                        <select disabled id="occupation2" class="form-select">
                            <option selected disabled>--กรุณาเลือก--</option>
                            <option value="1">One</option>
                            <option selected disabled value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <label for="level2" class="form-label">ระดับ</label>
                        <select disabled id="level2" class="form-select">
                            <option selected disabled>--กรุณาเลือก--</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option selected disabled value="3">Three</option>
                        </select>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="สัมภาษณ์" id="interview" checked disabled>
                            <label class="form-check-label" for="interview">
                              สัมภาษณ์
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="สาธิตการปฏิบัติงาน" id="show">
                            <label class="form-check-label" for="show">
                              สาธิตการปฏิบัติงาน
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="แฟ้มสะสมผลงาน" id="file" checked disabled>
                            <label class="form-check-label" for="file">
                              แฟ้มสะสมผลงาน
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="ประเมินด้วยบุคคลที่สาม" id="evaluate">
                            <label class="form-check-label" for="evaluate">
                              ประเมินด้วยบุคคลที่สาม
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="จำลองสถานการณ์" id="mock">
                            <label class="form-check-label" for="mock">
                              จำลองสถานการณ์
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="สังเกตการณ์ ณ หน้างานจริง" id="observe">
                            <label class="form-check-label" for="observe">
                              สังเกตุการณ์ ณ หน้างานจริง
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="RESK" id="resk">
                            <label class="form-check-label" for="resk">
                              RESK
                            </label>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-3">Type File</div>
                    <div class="col-md-3">
                        <div class="form-check ">
                            <input class="form-check-input" type="checkbox" value="ข้อเขียน" id="written">
                            <label class="form-check-label" for="written">
                              ข้อเขียน
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check ">
                            <input class="form-check-input" type="checkbox" value="อัตนัย" id="written2">
                            <label class="form-check-label" for="written2">
                              อัตนัย
                            </label>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <input type="text" class="form-control" value="ไฟล์ที่ 11" disabled>
                    </div>
                    <div class="col-md-12 mt-3">
                        <input type="text" class="form-control" placeholder="คำอธิบายไฟล์ :">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="file-upload-container" id="fileUploadContainer">
                            <input type="file" id="fileUpload" name="fileUpload">
                            <div class="plus-icon">+</div>
                            <div class="upload-text">Drag, Click, or Paste File Here</div>
                            <div id="fileName" class="file-name">No file selected</div>
                        </div>
                    
                        <script>
                            const fileInput2= document.getElementById("fileUpload");
                            const fileNameDisplay2= document.getElementById("fileName");
                            const fileUploadContainer2= document.getElementById("fileUploadContainer");
                    
                            // Handle file selection via input
                            fileInput2.addEventListener("change", handleFileSelect);
                    
                            // Handle drag-and-drop
                            fileUploadContainer2.addEventListener("dragover", (e) => {
                                e.preventDefault();
                                fileUploadContainer2.classList.add("active");
                            });
                    
                            fileUploadContainer2.addEventListener("dragleave", () => {
                                fileUploadContainer2.classList.remove("active");
                            });
                    
                            fileUploadContainer2.addEventListener("drop", (e) => {
                                e.preventDefault();
                                fileUploadContainer2.classList.remove("active");
                                const file = e.dataTransfer.files[0];
                                if (file) {
                                    displayFileName(file);
                                }
                            });
                    
                            // Handle file paste
                            fileUploadContainer2.addEventListener("paste", (e) => {
                                const items = e.clipboardData.items;
                                for (let i = 0; i < items.length; i++) {
                                    if (items[i].kind === "file") {
                                        const file = items[i].getAsFile();
                                        if (file) {
                                            displayFileName(file);
                                        }
                                    }
                                }
                            });
                    
                            // Display file name
                            function handleFileSelect() {
                                const file = fileInput2.files[0];
                                if (file) {
                                    displayFileName(file);
                                }
                            }
                    
                            function displayFileName(file) {
                                fileNameDisplay2.textContent = `File: ${file.name}`;
                            }
                        </script>
                    </div>
                </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    <div class="printme" id="div_print" style="display: none;"></div>
</section>
<!-- /.content -->

<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/interview/form.js?<?= date("YmdHis") ?>">
</script>