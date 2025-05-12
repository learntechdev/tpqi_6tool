function addDetailForm() {
	// Number of inputs to create
	var n = parseInt($("#num_type").val());
	var i = parseInt($("#num_detail").val());

	var port_type = document.getElementById("port_type");

	var port_detail = document.getElementById("port_detail");
	console.log(port_detail);

	var div = document.createElement("div");
	div.id = "port_detail_" + i;
	div.classList.add("col-md-12");

	var div1 = document.createElement("div");
	div1.classList.add("col-md-12");
	div.appendChild(div1);

	/* ---- ROW1 */
	var div2 = document.createElement("div");
	div2.classList.add("row");
	div1.appendChild(div2);

	var div3 = document.createElement("div");
	div3.classList.add("col-sm-9");
	div3.classList.add("py-2");
	div2.appendChild(div3);

	var div4 = document.createElement("div");
	div4.classList.add("col-auto");
	div3.appendChild(div4);

	var div5 = document.createElement("div");
	div5.classList.add("input-group");
	div5.classList.add("mb-1");
	div4.appendChild(div5);

	var div6 = document.createElement("div");
	div6.classList.add("input-group-prepend");
	div5.appendChild(div6);

	var span = document.createElement("span");
	span.id = "label_" + n + i;
	span.classList.add("label");
	div6.appendChild(span);

	var input = document.createElement("input");
	input.type = "text";
	input.id = "txt_input_" + n + i;
	input.name = "list[" + n + "][detail][" + i + "][file]";
	input.classList.add("form-control");
	div5.appendChild(input);

	var div7 = document.createElement("div");
	div7.classList.add("col-sm-3");
	div7.classList.add("py-2");
	div2.appendChild(div7);

	var input1 = document.createElement("input");
	input1.type = "radio";
	input1.value = "1";
	input1.id = "list[" + n + "][detail][" + i + "][status]";
	input1.name = "list[" + n + "][detail][" + i + "][status]";
	div7.appendChild(input1);

	var span = document.createElement("span");
	span.id = "label_r" + n + i;
	span.classList.add("label");
	div7.appendChild(span);

	var br = document.createElement("br");
	div7.appendChild(br);

	var input2 = document.createElement("input");
	input2.type = "radio";
	input2.value = "0";
	input2.name = "list[" + n + "][detail][" + i + "][status]";
	div7.appendChild(input2);

	var span = document.createElement("span");
	span.id = "label_r1" + n + i;
	span.classList.add("label");
	div7.appendChild(span);

	/* ---- ROW2 */
	var div8 = document.createElement("div");
	div8.classList.add("row");
	div1.appendChild(div8);

	var div9 = document.createElement("div");
	div9.classList.add("col-sm-11");
	div9.style.paddingLeft = "65px";
	div9.style.marginTop = "-25px";
	div8.appendChild(div9);

	var span = document.createElement("span");
	span.id = "label_info" + n + i;
	span.classList.add("label");
	div9.appendChild(span);

	var div10 = document.createElement("div");
	div10.classList.add("col-sm-9");
	div10.classList.add("py-2");
	div8.appendChild(div10);

	var div11 = document.createElement("div");
	div11.classList.add("col-auto");
	div10.appendChild(div11);

	var div12 = document.createElement("div");
	div12.classList.add("input-group");
	div12.classList.add("mb-1");
	div12.style.paddingLeft = "45px";
	div11.appendChild(div12);

	var input3 = document.createElement("input");
	input3.type = "text";
	input3.id = "txt_input1_" + n + i;
	input3.name = "list[" + n + "][detail][" + i + "][info]";
	input3.classList.add("form-control");
	div12.appendChild(input3);

	/* --------------------------- */

	port_type.appendChild(div);
	document.getElementById("label_" + n + i).innerHTML =
		n + 1 + "." + (i + 1) + " &nbsp;";
	document.getElementById("txt_input_" + n + i).style.backgroundColor = "#fff";
	document.getElementById("txt_input1_" + n + i).style.backgroundColor = "#fff";

	document.getElementById("label_r" + n + i).innerHTML = " จำเป็น";
	document.getElementById("label_r1" + n + i).innerHTML = " ไม่จำเป็น";

	document.getElementById("label_info" + n + i).innerHTML =
		"คำแนะนำในการส่งเอกสาร";

	document.getElementById(
		"list[" + n + "][detail][" + i + "][status]"
	).checked = true;

	console.log(div);

	//$("#num_type").val(n + 1);
	$("#num_detail").val(i + 1);

	//var element = document.getElementById("myDIV");
	//element.classList.add("mystyle");
}
