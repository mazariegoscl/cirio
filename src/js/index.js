$(document).ready(function() {
    data_modal();
});

function data_modal() {
    $(".data-modal").click(function() {
        //console.log("abrir");
        var modal = $(this).attr('data-target');
        $("#" + modal).show();
        $("body").css("overflow", "hidden");
    });

    $(".close-button").click(function() {
        //console.log("CERRAR");
        $(this).parent('.modal').hide();
        $("body").css("overflow", "auto");
    });
}
