$("#btn_add_examassign").click(function (e) {
	e.preventDefault();
	$.redirect("../../exam/ExamAssignment/create");
});

function cancel(exam_assign_id) {
	Swal.fire({
		title: "ยืนยัน!!!",
		text: "คุณต้องการลบข้อมูลใช่หรือไม่?",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		confirmButtonText: "ใช่",
		cancelButtonText: "ยกเลิก",
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				method: "POST",
				url: "../../exam/ExamAssignment/delete",
				data: {
					exam_assign_id: exam_assign_id,
				},
				dataType: "JSON",
				success: function (response) {
					if (response == 1) {
						success_alert("<strong>ลบข้อมูลเรียบร้อยแล้ว!!!</strong>");
						search(1);
					}
				},
			});
		}
	});
}


function edit(exam_assign_id) {
	$.redirect("../../exam/ExamAssignment/create", {
		exam_assign_id: exam_assign_id,
		action: "edit",
	});
}
