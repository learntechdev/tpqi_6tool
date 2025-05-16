$(document).ready(function () {
    var oldScore = $("#default_score").val();
    $("#default_score").on("focus", function() {
        oldScore = $(this).val();
    });
    $("#default_score").on("change", function() {
        var newScore = $(this).val(); // รับค่าจาก default_score
        $(".marks_for_q_new").each(function(){
            if (!$(this).val()) {
                $(this).val(newScore);
            }else{
                if (!$(this).attr("modified")) {
                    $(this).val(newScore);
                }
            }
        });
    });
    $(".marks_for_q_new").on("input", function() {
        $(this).attr("modified", "1");
        $(this).css("color", "green");
    });
});