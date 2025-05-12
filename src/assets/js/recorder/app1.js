//webkitURL is deprecated but nevertheless
URL = window.URL || window.webkitURL;

var gumStream; 						//stream from getUserMedia()
var rec; 							//Recorder.js object
var input; 							//MediaStreamAudioSourceNode we'll be recording

var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext

var recordButton = document.getElementById("recordButton");
var stopButton = document.getElementById("stopButton");
var pauseButton = document.getElementById("pauseButton");

recordButton.addEventListener("click", startRecording);
stopButton.addEventListener("click", stopRecording);
pauseButton.addEventListener("click", pauseRecording);

$("#recordingsList").empty();

function startRecording() {
	var constraints = { audio: true, video: false }

	recordButton.disabled = true;
	stopButton.disabled = false;
	pauseButton.disabled = false

	navigator.mediaDevices.getUserMedia(constraints).then(function (stream) {
		audioContext = new AudioContext();
		document.getElementById("formats").innerHTML = "รูปแบบ: 1 channel pcm @ " + audioContext.sampleRate / 1000 + "kHz"
		gumStream = stream;
		input = audioContext.createMediaStreamSource(stream);
		rec = new Recorder(input, { numChannels: 1 })
		rec.record()
	}).catch(function (err) {
		recordButton.disabled = false;
		stopButton.disabled = true;
		pauseButton.disabled = true
	});
}

function pauseRecording() {
	if (rec.recording) {
		rec.stop();
		pauseButton.innerHTML = "Resume";
	} else {
		rec.record()
		pauseButton.innerHTML = "Pause";
	}
}

function stopRecording() {
	stopButton.disabled = true;
	recordButton.disabled = false;
	pauseButton.disabled = true;
	pauseButton.innerHTML = "Pause";
	rec.stop();

	gumStream.getAudioTracks()[0].stop();
	rec.exportWAV(createDownloadLink);
}

function formatDate(date) {
	var d = new Date(date),
		month = '' + (d.getMonth() + 1),
		day = '' + d.getDate(),
		year = d.getFullYear();

	if (month.length < 2)
		month = '0' + month;
	if (day.length < 2)
		day = '0' + day;

	return [year, month, day].join('-');
}

function createDownloadLink(blob) {
	var url = URL.createObjectURL(blob);
	var au = document.createElement('audio');
	var li = document.createElement('li');
	var link = document.createElement('a');

	var template_detail_id = $("#template_detail_id").val()

	//var date_now = moment().format("mmmss");

	/*var pc_code = $("#txt_pc_code").val();
	if (pc_code == '') {
		var pc_code = $("#txt_uoc_code").val();
	}*/
	var filename = formatDate(new Date().toISOString()) + "_" + template_detail_id;
	au.controls = true;
	au.src = url;
	$("#txt_url").val(url);
	li.appendChild(au);
	li.appendChild(document.createTextNode(filename + ".wav "))
	$("#txt_filename").val(filename);
	li.appendChild(link);

	//upload link
	var upload = document.createElement('a');
	var app_id = $("#txt_app_id").val()

	var template_detail_id = $("#template_detail_id").val()
	var exam_schedule_id = $("#exam_schedule_id").val();

	upload.href = "#";
	upload.innerHTML = "อัพโหลด";
	upload.addEventListener("click", function (event) {
		var xhr = new XMLHttpRequest();
		xhr.onload = function (e) {
			if (this.readyState === 4) {
				//console.log(e.target.responseText)

				show_clip(e.target.responseText, template_detail_id);
				$("#modal_recorder").modal("hide");
				/*if (e.target.responseText == 1) {
					//success_alert("<strong>อัพโหลดคลิปเสียงเรียบร้อยแล้ว</strong>")
					$("#modal_recorder").modal("hide");
					show_clip();
				} else {
					sweet_alert("<strong>ไม่สามารถบันทึกได้</strong>");
				}*/
			} else {
				sweet_alert("<strong>ไม่สามารถบันทึกได้</strong>");
			}
		};
		var fd = new FormData();
		fd.append("audio_data", blob, filename);
		fd.append("app_id", app_id);
		fd.append("template_detail_id", template_detail_id);
		fd.append("exam_schedule_id", exam_schedule_id);

		fd.append("tool_type", "3")
		xhr.open("POST", "../../upload/UploadFiles/uploadfile?app_id='" + app_id + "'&tool_type=3", true);
		xhr.send(fd);
	})
	li.appendChild(document.createTextNode(" "))
	li.appendChild(upload)
	recordingsList.appendChild(li);
}

function show_clip(file, template_detail_id) {
	var elem = document.getElementsByClassName("audio-play" + template_detail_id);
	if (elem.length > 0) {
		$(".audio-play" + template_detail_id).remove();
	}

	var base_url = $("#base_url").val();
	var div_sound = document.getElementById("div_sound" + template_detail_id);

	var sound_play = document.createElement("AUDIO");
	sound_play.classList.add("audio");
	sound_play.classList.add("audio-play" + template_detail_id);

	if (sound_play.canPlayType("audio/wav")) {
		sound_play.setAttribute("src", base_url + file);
	}
	sound_play.setAttribute("controls", "controls");

	setTimeout(() => {
		div_sound.appendChild(sound_play);

	}, 500);

}

