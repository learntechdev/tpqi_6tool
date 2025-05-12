//อัพโหลดไฟล์ตาม UOC
$(document).ready(function () {});

$(".file").change(function () {
	if ($(this).get(0).files[0] != undefined) {
		var file_name = $(this).get(0).files[0].name; //ชื่อไฟล์
		var size = $(this).get(0).files[0].size; // ขนาดไฟล์
		var max = 500000000; //ขนาดไฟล์กำหนดสูงสุด
		var ext = file_name.split(".").pop(); //นามสกุลไฟล์
		if (size < max) {
			if (
				ext != "pdf" &&
				ext != "jpg" &&
				ext != "png" &&
				ext != "ppt" &&
				ext != "pptx" &&
				ext != "xls" &&
				ext != "xlsx" &&
				ext != "doc" &&
				ext != "docx" &&
				ext != "mp4" &&
				ext != "mp3"
			) {
				sweet_alert("<strong>นามสกุลไฟล์ไม่ถูกต้อง</strong>");
				$(this).val("");
			} else {
				id_ = $(this).attr("id");
				document.getElementsByName(id_)[0].textContent = "";
			}
		} else {
			sweet_alert("<strong>ขนาดไฟล์เกิน 50 Mb</strong>");
			$(this).val("");
		}
	}
});

//ตรวจสอบว่าเลือกไฟล์ครบหรือไม่
function validateFile() {
	var chk_file = true;
	if ($("#form_type").val() == "create") {
		$(".file").each(function () {
			id_ = $(this).attr("id");
			if (document.getElementById(id_).files.length < 1) {
				document.getElementsByName(id_)[0].textContent = "*กรุณาเลือกไฟล์";
				chk_file = false;
			} else {
				document.getElementsByName(id_)[0].textContent = "";
			}
		});
	} else {
		var count_hasfile = 0;
		$(".file").each(function () {
			id_ = $(this).attr("id");
			if (document.getElementById(id_).files.length == 0) {
				chk_file = false;
			} else {
				chk_file = true;
				count_hasfile++;
			}
		});
		if (count_hasfile >= 1) {
			chk_file = true;
		}
	}

	return chk_file;
}

$("form").submit(function (e) {
	e.preventDefault();
	//var data = $("form").serializeJSON();

	if ($("#form_type").val() == "create") {
		if (validateFile() == true) {
			Swal.fire({
				title: "ยืนยัน!!!",
				text: "กรุณาตรวจสอบข้อมูลให้ถูกต้องก่อนยืนยันการบันทึกข้อมูล \n คุณต้องการบันทึกข้อมูลใช่หรือไม่?",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				confirmButtonText: "ใช่",
				cancelButtonText: "ยกเลิก",
			}).then((result) => {
				if (result.isConfirmed) {
					save();
				}
			});
		} else {
			sweet_alert("<strong>กรุณาเลือกไฟล์ให้ครบ</strong>");
		}
	} else {
		if (validateFile() == true) {
			Swal.fire({
				title: "ยืนยัน!!!",
				text: "กรุณาตรวจสอบข้อมูลให้ถูกต้องก่อนยืนยันการบันทึกข้อมูล \n คุณต้องการบันทึกข้อมูลใช่หรือไม่?",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				confirmButtonText: "ใช่",
				cancelButtonText: "ยกเลิก",
			}).then((result) => {
				if (result.isConfirmed) {
					save();
				}
			});
		} else {
			sweet_alert("<strong>ไม่มีการแก้ไขรายการของไฟล์ที่ได้อัพโหลด</strong>");
		}
	}
});

function save() {
	var file = [];
	var idx = [];
	i = 0;
	$(".file").each(function () {
		id_ = $(this).attr("id");
		var filename = document
			.getElementById(id_)
			.value.replace(/C:\\fakepath\\/i, "");
		if (filename != "") {
			file[i] = document.getElementById(id_).files;
			idx[i] = id_;
			i++;
		}
		//file[i] = document.getElementById(id_).files;
		//i++;
	});
	prepareFile(file, idx);
}

function prepareFile(fileList, idx) {
	var data_array = $("form").serializeJSON();
	var i = 0;
	var j = 0;
	var str_idx = [];
	//str_idx = idx;
	//alert(str_idx["list"]);
	$("#uploadsts").empty();
	for (i = 0; i < fileList.length; i++) {
		$("#uploadsts").append(
			"<p>" +
				fileList[i][0].name +
				'<span class="loading-prep" id="prog' +
				i +
				'"></span></p>'
		);
		if (i == fileList.length - 1) {
			uploadajax(fileList, fileList.length - 1, 0, JSON.stringify(data_array));
		}
		j++;
	}
}

function uploadajax(fileList, ttl, cl, dt_array) {
	//alert("ttl:" + ttl + ",cl:" + cl);
	bp.showLoading();
	console.log("dt_array1:" + dt_array);
	var form_data = "";
	var data = JSON.parse(dt_array);
	var str_dt = data["list"][cl + 1];
	//	console.log("data:" + data["list"].tp_checklist_id);
	//console.log("fileList:" + fileList[cl][0]);
	//console.log("str_dt.tp_checklist_id:" + str_dt.tp_checklist_id);

	form_data = new FormData();
	form_data.append("upload", fileList[cl][0]);
	form_data.append("action", $("#form_type").val());
	form_data.append("app_id", $("#app_id").val());
	form_data.append("blueprint_id", $("#blueprint_id").val());
	form_data.append("tpqi_exam_no", $("#exam_schedule_id").val());
	form_data.append("tp_checklist_id", str_dt.tp_checklist_id);
	form_data.append("uoc_code", str_dt.uoc_code);
	form_data.append("maintopic_id", str_dt.maintopic_id);
	form_data.append("subtopic_id", str_dt.subtopic_id);

	$.ajax({
		url: "../Portfolio/uploadFile",
		cache: false,
		contentType: false,
		processData: false,
		async: true,
		data: form_data,
		type: "POST",
		xhr: function () {
			var xhr = $.ajaxSettings.xhr();
			if (xhr.upload) {
				xhr.upload.addEventListener(
					"progress",
					function (event) {
						var percent = 0;
						if (event.lengthComputable) {
							percent = Math.ceil((event.loaded / event.total) * 100);
						}
						$("#prog" + cl).text(percent + "%");
					},
					false
				);
			}
			return xhr;
		},
		success: function (res, status) {
			if (res == 1) {
				percent = 0;
				$("#prog" + cl).text("");
				$("#prog" + cl).text("--Success: ");
				if (cl < ttl) {
					uploadajax(fileList, ttl, cl + 1, dt_array);
				} else {
					success_alert("<strong>บันทึกข้อมูลเรียบร้อยแล้ว!!!</strong>");
					$.redirect("../../assessment/PersonAssessment/index");
					bp.hideLoading();
				}
			} else {
				success_alert("<strong>ไม่สามารถอัพโหลดไฟล์ได้!!!</strong>");
				bp.hideLoading();
			}
		},
		fail: function (res) {
			success_alert("<strong>ไม่สามารถอัพโหลดไฟล์ได้!!!</strong>");
			bp.hideLoading();
		},
	});
}

/*
function submit_form() {
	var data = $("form").serializeJSON();
	//console.log("file:" + $("form").serializeJSON());
	var file = [];
	i = 0;
	$(".file").each(function () {
		id_ = $(this).attr("id");
		file[i] = document.getElementById(id_).files;
		i++;
	});

	//console.log(file);
	//console.log("data from:" + JSON.stringify($("form").serializeJSON()));
	uploadFileAssessor(file, data);
}
*/

function uploadFileAssessor(file_array, data_array) {
	var j = 0;
	var last_file = 0;
	for (i = 0; i < file_array.length; i++) {
		j++;
		if (file_array[i].length > 0) {
			var data = data_array.list[j];
			//console.log("data:" + data.uoc_code);

			var q_code = data.uoc_code;
			if (q_code == "") {
				q_code = data.subtopic_id;
			}

			//  console.log(file_array[i][0].name)

			var myfile = file_array[i][0].name;
			var ext = myfile.split(".").pop();
			var url = "../Portfolio/uploadFile";
			var xhr = new XMLHttpRequest();
			var fd = new FormData();
			xhr.open("POST", url, true);
			xhr.onreadystatechange = function () {
				bp.showLoading();

				if (xhr.readyState == 4 && xhr.status == 200) {
					//alert(xhr.responseText);
					if (xhr.responseText == 1) {
						bp.hideLoading();
					}

					//var count_file = parseInt(file_array.length);
					//count_file = count_file - 1;
					/*if (i == count_file) {
						bp.hideLoading();
						insertAssessmentData(data_array);
					}*/
				}
			};

			fd.append("upload_file", file_array[i][0]);
			fd.append("app_id", data.app_id);
			fd.append(
				"name_flie",
				data.app_id +
					"_" +
					data.blueprint_id +
					"_" +
					q_code +
					"_" +
					data.order_line +
					"." +
					ext
			); //ชื่อไฟล์+นามสกุล
			fd.append("data", JSON.stringify(data));
			data_array.list[j].file =
				data.app_id +
				"_" +
				data.blueprint_id +
				"_" +
				q_code +
				"_" +
				data.order_line +
				"." +
				ext;
			//fd.append("data", data_array);
			xhr.send(fd);

			last_file++;
		} else {
			data_array.list[j].file = data_array.list[j].file_old;
			console.log(data_array.list[j].file);
		}

		var count_file = parseInt(file_array.length);
		count_file = count_file - 1;

		//alert("i:" + i + " count f:" + count_file);

		bp.showLoading();
		if (i == count_file) {
			//	alert("i:" + i);
			//alert("count_file:" + count_file);
			insertAssessmentData(data_array);
			bp.hideLoading();
		} else {
			//alert("i:นอก" + i);
		}
	}
}

function goto_person_assessment() {
	$.redirect("../../assessment/PersonAssessment/index");
}
