<script>
function addPortfolioType() {

     var option_select = <?php echo json_encode($portfolio_type); ?>


    if ($("#num_detail").val() == 0) {
        alert("กรุณาเพิ่มรายการ");
    } else {
        var port_type = document.getElementById("port_type");
        console.log(port_type);

        $("#num_type").val(parseInt($("#num_type").val()) + 1);
        $("#num_detail").val(0);

        var n = parseInt($("#num_type").val());
        var i = parseInt($("#num_detail").val());

        //var form = document.getElementById("form").innerHTML;

        var div = document.createElement("div");
        div.classList.add("col-md-12");

        var div1 = document.createElement("div");
        div1.classList.add("row");
        div.appendChild(div1);

        var div2 = document.createElement("div");
        div2.classList.add("col-md-12");
        div2.classList.add("py-2");
        div2.style.backgroundColor = "#eeeeee";
        div1.appendChild(div2);

        var div3 = document.createElement("div");
        div3.classList.add("col-auto");
        div2.appendChild(div3);

        var div4 = document.createElement("div");
        div4.classList.add("input-group");
        div4.classList.add("mb-1");
        div3.appendChild(div4);

        var div5 = document.createElement("div");
        div5.classList.add("input-group-prepend");
        div4.appendChild(div5);

        var span = document.createElement("span");
        span.id = "label_p" + n + i;
        span.classList.add("label_head");
        div5.appendChild(span);

    

        var input = document.createElement("select");
        input.name = "list[" + n + "][portfolio_type]";
        input.classList.add("form-control");
        div4.appendChild(input);

        for(var m=0;m<option_select.length;m++){
            var opt = document.createElement("option");
            opt.appendChild(document.createTextNode(option_select[m].name));
            opt.value = option_select[m].id;
            input.appendChild(opt);
        }
      

        ////////////////////////////////////
        port_type.appendChild(div);
        document.getElementById("label_p" + n + i).innerHTML = n + 1 + " &nbsp;";

        console.log(port_type);
    }

    addDetailForm();
}
</script>