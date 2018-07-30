<div class="wrapper-charts">
    <h1 class="title-app">Ventas</h1>
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
        url: "helper/listaVentasFechas&" + dataString,
        data: dataString,
        success: function (datos) {
            var resultado = JSON.parse(datos);

            var listaHTML = "";

            $.each(resultado, function (i, e) {
                listaHTML += '<div class="box-3 box-3-style2">' +
                '<div class="wrapper-box-content">' +
                '<h3 class="title-box h3-style2">' + e.NombrePropiedad +'</h3>' +
                '<hr />' +
                '<div class="table-main-3">' +
                '<div class="col-main-2">Ventas</div>' +
                '<div class="col-main-2">' + formatNumber(e.Ventas) + '</div>' +
                '<div class="col-main-2">Tarifa <span style="color: red;">S/N</span> Descuento</div>' +
                '<div class="col-main-2">' + formatNumber(e.Tarifas) + '</div>' +
                '<div class="col-main-2">Descuentos</div>' +
                '<div class="col-main-2">' + formatNumber(e.Descuentos) + '</div>' +
                '<div class="col-main-2">Gastos</div>' +
                '<div class="col-main-2">' + formatNumber(e.Gastos) + '</div>' +
                '<div class="col-main-2">Depositos</div>';
                if(e.Depositos >= 0) {
                    listaHTML += '<div class="col-main-2"><span style="color: green;">' + formatNumber(e.Depositos) + '</span></div>';
                } else {
                    listaHTML += '<div class="col-main-2"><span style="color: red;">' + formatNumber(e.Depositos) + '</span></div>';
                }
                listaHTML += '<div class="col-main-2">Utilidad</div>' +
                '<div class="col-main-2">' + formatNumber(e.Utilidad - e.Comisiones) + '</div>' +
                '<div class="col-main-2">Ocupación</div>';
                if(e.DiasOcupacion > 1 || e.DiasOcupacion <= 0) {
                    listaHTML += '<div class="col-main-2">' + e.DiasOcupacion  + ' Noches' + '</div>';
                } else {
                    listaHTML += '<div class="col-main-2">' + e.DiasOcupacion  + ' Noche' + '</div>';
                }
                listaHTML += '</div>' +
                '<div class="col-main-2">Comisiones</div>' +
                '<div class="col-main-2">' + formatNumber(e.Comisiones) + '</div>' +
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
        url: "helper/listaVentas",
        success: function (datos) {
            var resultado = JSON.parse(datos);

            var listaHTML = "";

            $.each(resultado, function (i, e) {
                listaHTML += '<div class="box-3 box-3-style2">' +
                '<div class="wrapper-box-content">' +
                '<h3 class="title-box h3-style2">' + e.NombrePropiedad +'</h3>' +
                '<hr />' +
                '<div class="table-main-3">' +
                '<div class="col-main-2">Ventas</div>' +
                '<div class="col-main-2">' + formatNumber(e.Ventas) + '</div>' +
                '<div class="col-main-2">Tarifa <span style="color: red;">S/N</span> Descuento</div>' +
                '<div class="col-main-2">' + formatNumber(e.Tarifas) + '</div>' +
                '<div class="col-main-2">Descuentos</div>' +
                '<div class="col-main-2">' + formatNumber(e.Descuentos) + '</div>' +
                '<div class="col-main-2">Gastos</div>' +
                '<div class="col-main-2">' + formatNumber(e.Gastos) + '</div>' +
                '<div class="col-main-2">Depositos</div>';
                if(e.Depositos >= 0) {
                    listaHTML += '<div class="col-main-2"><span style="color: green;">' + formatNumber(e.Depositos) + '</span></div>';
                } else {
                    listaHTML += '<div class="col-main-2"><span style="color: red;">' + formatNumber(e.Depositos) + '</span></div>';
                }
                listaHTML += '<div class="col-main-2">Utilidad</div>' +
                '<div class="col-main-2">' + formatNumber(e.Utilidad - e.Comisiones) + '</div>' +
                '<div class="col-main-2">Ocupación</div>';
                if(e.DiasOcupacion > 1 || e.DiasOcupacion <= 0) {
                    listaHTML += '<div class="col-main-2">' + e.DiasOcupacion  + ' Noches' + '</div>';
                } else {
                    listaHTML += '<div class="col-main-2">' + e.DiasOcupacion  + ' Noche' + '</div>';
                }
                listaHTML += '</div>' +
                '<div class="col-main-2">Comisiones</div>' +
                '<div class="col-main-2">' + formatNumber(e.Comisiones) + '</div>' +
                '</div>' +
                '</div>';
            });

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
