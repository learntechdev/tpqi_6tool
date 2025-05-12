function sweet_alert(txt) {
	Swal.fire({
		icon: 'error',
		title: 'แจ้งเตือน',
		html: txt,
		confirmButtonText: 'ตกลง',
	  });
}

function success_alert(txt) {
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: txt,
        showConfirmButton: false,
        timer: 1500
        //confirmButtonText: 'ตกลง'
      });
}

function success_alert1(txt) {
	Swal.fire({
		icon: 'success',
		title: txt,
		html: txt,
		confirmButtonText: 'ตกลง',
	  });
}