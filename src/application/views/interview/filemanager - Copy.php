<?php // $this->load->view("breadcrumb/breadcrumb", $breadcrumb); ?>
<div class="content-header">
    <h3> ตัวจัดการไฟล์
    </h3>

    <ol class="breadcrumb">
        <?php
        if ($_SESSION["user_type"] == '8') {
            $url = "../../asmtools/ASMTools/index";
        } else {
            $url = "../../interview/InterviewTool/file_manager";
        } ?>


        <li class="breadcrumb-item ">
            <a href="<?= $url ?>">หน้าแรก</a>
        </li>
		<li class="breadcrumb-item ">
            <a href="<?= $url ?>">ชุดทดสอบเก็บถาวร</a>
        </li>

        <li class="breadcrumb-item active">
            <a href="../../interview/InterviewTool/file_manager" style="color:red">อัพโหลดไฟล์</a>
        </li>
    </ol>
</div>
<input type="hidden" name="asm_tool" id="asm_tool" value='<?= $asm_tool_type ?>'>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="min-height:480px">
                <div class="card-body">
				<nav class="nav-bar">
					<div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="label_head">อัปโหลดไฟล์ของคุณที่นี่</span>
							
                            <hr />
                        </div>

                        <div class="col-md-12">
                            <form id="form" name="form">
                                <div class="col-md-12">
                                    <<div class="row">
                <div class="col-md-12 px-5">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                         <p class="manage__file__style">จัดการไฟล์</p>
                         <p class="breadcrumb__blue">หน้าแรก - คลังชุดข้อสอบ - <span class="breadcrumb__red">คัดลอกชุดข้อสอบ</span></p>
                    </div>
                    <div class="bg__white__screen">
                        <div class="container-fluid">
                            <div class="col-md-12">
                                <p class="manage__file__system__style mb-4">หน้าจัดการไฟล์ในระบบ</p>
                                <hr>
                            </div>
                            <form action="">
                                <div class="row mt-5">
                                    <div class="col-12 col-md-6 col-lg-3 mb-3">
                                        <label for="qualification" class="form-label">คุณวุฒิวิชาชีพ</label>
                                        <select id="qualification" class="form-select">
                                            <option selected disabled>--กรุณาเลือก--</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3 mb-3">
                                        <label for="branch" class="form-label">สาขา</label>
                                        <select id="branch" class="form-select">
                                            <option selected disabled>--กรุณาเลือก--</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3 mb-3">
                                        <label for="occupation" class="form-label">อาชีพ</label>
                                        <select id="occupation" class="form-select">
                                            <option selected disabled>--กรุณาเลือก--</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3 mb-3">
                                        <label for="qualification" class="form-label">ระดับ</label>
                                        <select id="qualification" class="form-select">
                                            <option selected disabled>--กรุณาเลือก--</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    
                                    <div class="col-12 col-md-6 col-lg-2 mb-3">
                                        <label for="branch" class="form-label">ประเภทไฟล์</label>
                                        <select id="branch" class="form-select">
                                            <option selected disabled>--กรุณาเลือก--</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
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
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header upload__title">
                                                  <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                                                  <button type="button" class="btn-close white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                  <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-12 col-md-12 col-lg-12">
                                                            <label for="qualification2" class="form-label">คุณวุฒิวิชาชีพ</label>
                                                            <select id="qualification2" class="form-select">
                                                                <option selected disabled>--กรุณาเลือก--</option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select>
                                                    <div class="row">
                                                        <div class="col-12 col-md-12 col-lg-12">
                                                            <label for="branch2" class="form-label">สาขา</label>
                                                            <select id="branch2" class="form-select">
                                                                <option selected disabled>--กรุณาเลือก--</option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-md-12 col-lg-12">
                                                            <label for="occupation2" class="form-label">อาชีพ</label>
                                                            <select id="occupation2" class="form-select">
                                                                <option selected disabled>--กรุณาเลือก--</option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-md-12 col-lg-12">
                                                            <label for="level2" class="form-label">ระดับ</label>
                                                            <select id="level2" class="form-select">
                                                                <option selected disabled>--กรุณาเลือก--</option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select>
                                                        </div>
                                                    </div>    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-check mt-3">
                                                                <input class="form-check-input" type="checkbox" value="สัมภาษณ์" id="interview">
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
                                                                <input class="form-check-input" type="checkbox" value="แฟ้มสะสมผลงาน" id="file">
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
                                                            <input type="text" class="form-control">
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
                                                  <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                    </div>
                                        

                                    </div>
                                </div>
                            </form>
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
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>คุณวุฒิวิชาชีพ 1</td>
                                            <td>สาขา 1</td>
                                            <td>อาชีพ 1</td>
                                            <td>ระดับ 2</td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-subtract-line"></i>
                                                    <i class="ri-check-line check"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                               
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-check-line check"></i>
                                                    <i class="ri-subtract-line"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-subtract-line"></i>
                                                    <i class="ri-check-line check"></i>
                                                    <i class="ri-check-line check"></i>
                                                </div>
                                            </td>
                                            <td >
                                                <div class="d-flex flex-column align-items-center">
                                                     <i class="ri-check-line check"></i>
                                                    <i class="ri-subtract-line"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                     <i class="ri-check-line check"></i>
                                                    <i class="ri-subtract-line"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-subtract-line"></i>
                                                    <i class="ri-check-line check"></i>
                                                    <i class="ri-check-line check"></i>       
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                     <i class="ri-subtract-line"></i>
                                                    <i class="ri-subtract-line"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                     <p>ชื่อไฟล์ 2</p>
                                                    <p>ชื่อไฟล์ 1</p>
                                                    <p>ชื่อไฟล์ 3</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <p>สมชาย จริงใจ</p>
                                                    <p>สมชาย จริงใจ</p>
                                                    <p>สมชาย จริงใจ</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <p>11/12/2566</p>
                                                    <p>12/12/2566</p>
                                                    <p>10/12/2566</p>
                                                </div>
                                            </td>
                                            <td class="d-flex flex-column align-items-center">
                                                <div class="d-flex flex-row justify-content-center align-items-center">
                                                    <div class=" cursor" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="ri-pencil-fill yellow"></i><span class="yellow me-2">แก้ไข</span></div>
                                                    <i class="ri-delete-bin-7-fill red"></i><span class="red">ลบ</span>
                                                </div>
                                                <div class="d-flex flex-row justify-content-center align-items-center">
                                                    <i class="ri-pencil-fill yellow"></i><span class="yellow me-2">แก้ไข</span>
                                                    <i class="ri-delete-bin-7-fill red"></i><span class="red">ลบ</span>
                                                </div>
                                                <div class="d-flex flex-row justify-content-center align-items-center">
                                                    <i class="ri-pencil-fill yellow"></i><span class="yellow me-2">แก้ไข</span>
                                                    <i class="ri-delete-bin-7-fill red"></i><span class="red">ลบ</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>คุณวุฒิวิชาชีพ 2</td>
                                            <td>สาขา 2</td>
                                            <td>อาชีพ 2</td>
                                            <td>ระดับ 4</td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-subtract-line"></i>
                                                    <i class="ri-check-line check"></i>
                                                </div>
                                               
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-check-line check"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-subtract-line"></i>
                                                    <i class="ri-check-line check"></i>
                                                </div>
                                            </td>
                                            <td >
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-subtract-line"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                     <i class="ri-check-line check"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-check-line check"></i>
                                                    <i class="ri-check-line check"></i>       
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                     <i class="ri-subtract-line"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                     <p>ชื่อไฟล์ 4</p>
                                                    <p>ชื่อไฟล์ 5</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <p>สมศรี ปทุมวัน</p>
                                                    <p>สมศรี ปทุมวัน</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <p>07/12/2566</p>
                                                    <p>05/12/2566</p>
                                                </div>
                                            </td>
                                            <td class="d-flex flex-column align-items-center">
                                                <div class="d-flex flex-row justify-content-center align-items-center">
                                                    <i class="ri-pencil-fill yellow"></i><span class="yellow me-2">แก้ไข</span>
                                                    <i class="ri-delete-bin-7-fill red"></i><span class="red">ลบ</span>
                                                </div>
                                                <div class="d-flex flex-row justify-content-center align-items-center">
                                                    <i class="ri-pencil-fill yellow"></i><span class="yellow me-2">แก้ไข</span>
                                                    <i class="ri-delete-bin-7-fill red"></i><span class="red">ลบ</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>คุณวุฒิวิชาชีพ 3</td>
                                            <td>สาขา 3</td>
                                            <td>อาชีพ 3</td>
                                            <td>ระดับ 5</td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-subtract-line"></i>
                                                    <i class="ri-check-line check"></i>
                                                </div>
                                               
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-check-line check"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-subtract-line"></i>
                                                    <i class="ri-check-line check"></i>
                                                </div>
                                            </td>
                                            <td >
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-subtract-line"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                     <i class="ri-check-line check"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-check-line check"></i>
                                                    <i class="ri-check-line check"></i>       
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                     <i class="ri-subtract-line"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                     <p>ชื่อไฟล์ 6</p>
                                                    <p>ชื่อไฟล์ 7</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <p>น้ำใส ใจสะอาด</p>
                                                    <p>น้ำใส ใจสะอาด</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <p>04/12/2566</p>
                                                    <p>03/12/2566</p>
                                                </div>
                                            </td>
                                            <td class="d-flex flex-column align-items-center">
                                                <div class="d-flex flex-row justify-content-center align-items-center">
                                                    <i class="ri-pencil-fill yellow"></i><span class="yellow me-2">แก้ไข</span>
                                                    <i class="ri-delete-bin-7-fill red"></i><span class="red">ลบ</span>
                                                </div>
                                                <div class="d-flex flex-row justify-content-center align-items-center">
                                                    <i class="ri-pencil-fill yellow"></i><span class="yellow me-2">แก้ไข</span>
                                                    <i class="ri-delete-bin-7-fill red"></i><span class="red">ลบ</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>คุณวุฒิวิชาชีพ 3</td>
                                            <td>สาขา 3</td>
                                            <td>อาชีพ 3</td>
                                            <td>ระดับ 6</td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-subtract-line"></i>
                                                    <i class="ri-check-line check"></i>
                                                </div>
                                               
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-check-line check"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-subtract-line"></i>
                                                    <i class="ri-check-line check"></i>
                                                </div>
                                            </td>
                                            <td >
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-subtract-line"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                     <i class="ri-check-line check"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-check-line check"></i>
                                                    <i class="ri-check-line check"></i>       
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                     <i class="ri-subtract-line"></i>
                                                    <i class="ri-subtract-line"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                     <p>ชื่อไฟล์ 8</p>
                                                    <p>ชื่อไฟล์ 9</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <p>สุชาติ บางเขต</p>
                                                    <p>สุชาติ บางเขต</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <p>01/12/2566</p>
                                                    <p>01/12/2566</p>
                                                </div>
                                            </td>
                                            <td class="d-flex flex-column align-items-center">
                                                <div class="d-flex flex-row justify-content-center align-items-center">
                                                    <i class="ri-pencil-fill yellow"></i><span class="yellow me-2">แก้ไข</span>
                                                    <i class="ri-delete-bin-7-fill red"></i><span class="red">ลบ</span>
                                                </div>
                                                <div class="d-flex flex-row justify-content-center align-items-center">
                                                    <i class="ri-pencil-fill yellow"></i><span class="yellow me-2">แก้ไข</span>
                                                    <i class="ri-delete-bin-7-fill red"></i><span class="red">ลบ</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                                </div>
                            </form>
                        </div>
                    </div>
					</div>
					</nav>
                </div>
            </div>
        </div>
    </div>

    <div class="printme" id="div_print" style="display: none;"></div>
</section>
<!-- /.content -->

<script type="text/javascript" src="<?= base_url(); ?>assets/custom_js/interview/form.js?<?= date("YmdHis") ?>">
</script>