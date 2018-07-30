<div class="wrapper-charts">
    <h1 class="title-app">Comisiones</h1>
    <div class="filters">
        <div class="form-control">
            <label>
                Fecha de inicio
            </label>
            <input id="first_date_find" type="date" value="2018-03-01" />
        </div>

        <div class="form-control">
            <label>
                Fecha final
            </label>
            <input id="second_date_find" type="date" value="2018-03-02" />
        </div>

        <div class="form-control" style="vertical-align: bottom;">
            <button id="find_reservations">Buscar</button>
        </div>
    </div>
    <div id="listaVentas">
    </div>
</div>

<script>
$(document).ready(function() {
    desplegarInformacionInicial();

    $("#find_reservations").click(function() {
        desplegarInformacion();
    });
});

function desplegarInformacion() {
    var init_date = $("#first_date_find").val();
    var finish_date = $("#second_date_find").val();
    var dataString = 'fechaInicial=' + init_date + '&fechaFinal=' + finish_date;

    $.ajax({
        type: "GET",
        url: "helper/listaComisionesFechas&" + dataString,
        data: dataString,
        success: function (datos) {
            var resultado = JSON.parse(datos);

            var listaHTML = "";

            $.each(resultado, function (i, e) {
                listaHTML += '<div class="box-3 box-3-style2">' +
                '<div class="wrapper-box-content">' +
                '<h3 class="title-box h3-style2">' + e.name_property +'</h3>' +
                '<hr />' +
                '<div class="table-main-3">';
                $.each(e.commissions, function(u, o) {
                    listaHTML +='<div class="col-main-2">' + o.name + '</div>' +
                    '<div class="col-main-2">' + formatNumber(o.quantity) + '</div>';
                });

                listaHTML += '</div>' +
                '</div>' +
                '</div>';
            });

            $("#listaVentas").empty();
            $("#listaVentas").append(listaHTML);
            $(".wrapper-box-content > h3").first().css("color", "red");
        }
    });
}

function desplegarInformacionInicial() {
    $.ajax({
        type: "GET",
        url: "helper/listaComisiones",
        success: function (datos) {
            var resultado = JSON.parse(datos);

            var listaHTML = "";

            $.each(resultado, function (i, e) {
                listaHTML += '<div class="box-3 box-3-style2">' +
                '<div class="wrapper-box-content">' +
                '<h3 class="title-box h3-style2">' + e.name_property +'</h3>' +
                '<hr />' +
                '<div class="table-main-3">';
                $.each(e.commissions, function(u, o) {
                    listaHTML +='<div class="col-main-2">' + o.name + '</div>' +
                    '<div class="col-main-2">' + formatNumber(o.quantity) + '</div>';
                });

                listaHTML += '</div>' +
                '</div>' +
                '</div>';
            });

            $("#listaVentas").empty();
            $("#listaVentas").append(listaHTML);
            $(".wrapper-box-content > h3").first().css("color", "red");
        }
    });
}

function formatNumber(valor) {

    var decimales =  2; 
    return "$" + Number(valor).toFixed(decimales).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}
</script>
