<div class="wrapper-charts">
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
            <button id="find_stats">Buscar</button>
        </div>
    </div>

    <div class="box-3">
        <div class="wrapper-box-content">
            <h3 class="title-box">Ventas</h3>
            <h1 id="ventas" class="text-box green-text"><img src="assets/img/spinner.gif" width="25" height="25"></h1>
            <small class="date-box">01/01/2018 - 28/02/2018</small>
        </div>
    </div>
    <div class="box-3">
        <div class="wrapper-box-content">
            <h3 class="title-box">Gastos</h3>
            <h1 id="gastos" class="text-box blue-text"><img src="assets/img/spinner.gif" width="25" height="25"></h1>
            <small class="date-box">01/01/2018 - 28/02/2018</small>
        </div>
    </div>
    <div class="box-3">
        <div class="wrapper-box-content">
            <h3 class="title-box">Tarifa Promedio Diaria</h3>
            <h1 id="tarifaPromedioDiaria" class="text-box blue-text"><img src="assets/img/spinner.gif" width="25" height="25"></h1>
            <small class="date-box">01/01/2018 - 28/02/2018</small>
        </div>
    </div>

    <div class="box-3">
        <div class="wrapper-box-content">
            <h3 class="title-box">Porcentaje de Ocupación</h3>
            <div class="table-main-2">
                <div class="col-main-2" style="margin-bottom: 20px;">
                    Propiedad
                </div>
                <div class="col-main-2" style="margin-bottom: 20px; color: red;">
                    Porcentaje
                </div>
                <div id="porcentajes"><img src="assets/img/spinner.gif" width="25" height="25"></div>
                <div class="wrapper-total-percent">
                    <div class="col-main-2">
                        <span>Porcentaje Promedio:</span>
                    </div>
                    <div class="col-main-2">
                        <h2 id="porcentajePromedio"><img src="assets/img/spinner.gif" width="25" height="25"></h2>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="box-2">
        <div class="wrapper-box-content">
            <h3 class="title-box">Plataforma</h3>
            <div class="wrapper-chart-index">
                <div class="title-chart">
                    Sitio web
                </div>
                <!-- EMPIEZA CHART -->
                <div class="wrapper-chart-content">
                    <div class="medition-chart">
                        <!--<div class="line-chart" style="width: 63.63%"></div>
                        <span class="text-percent" style="left: calc(63.63% - 7px);">70</span>-->
                        <div class="line-chart" style="width: 0%"></div>
                        <span class="text-percent" style="left: calc(0% - 7px);">0</span>
                    </div>
                </div>
                <div class="title-chart">
                    Air BnB
                </div>
                <div class="wrapper-chart-content">
                    <div class="medition-chart">
                        <div class="line-chart" style="width: 0%"></div>
                        <span class="text-percent" style="left: calc(0% - 7px);">0</span>
                    </div>
                </div>

                <div class="title-chart">
                    VRBO
                </div>
                <div class="wrapper-chart-content">
                    <div class="medition-chart">
                        <div class="line-chart" style="width: 0%"></div>
                        <span class="text-percent" style="left: calc(0% - 7px);">0</span>
                    </div>
                </div>

                <div class="title-chart">
                    Agentes
                </div>
                <div class="wrapper-chart-content">
                    <div class="medition-chart">
                        <div class="line-chart" style="width: 0%"></div>
                        <span class="text-percent" style="left: calc(0% - 7px);">0</span>
                    </div>
                </div>
                <div class="title-chart"></div>
                <div class="wrapper-chart-content">
                    <div class="medition-chart-main">
                        <div class="number-chart">0</div>
                        <div class="number-chart">10</div>
                        <div class="number-chart">20</div>
                        <div class="number-chart">30</div>
                        <div class="number-chart">40</div>
                        <div class="number-chart">50</div>
                        <div class="number-chart">60</div>
                        <div class="number-chart">70</div>
                        <div class="number-chart">80</div>
                        <div class="number-chart">90</div>
                        <div class="number-chart">100</div>
                    </div>
                </div>
            </div>
            <!-- TERMINA CHART -->
        </div>
    </div>
</div>

<script>
function formatNumber(valor) {
    var decimales = 2;
    return "$" + Number(valor).toFixed(decimales).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}

$.get({
    url: "helper/dashBoard",
    success: function(datos) {
        var resultado = JSON.parse(datos);

        $("#ventas").text(formatNumber(resultado.Ventas) + " USD");
        $("#gastos").text(formatNumber(resultado.Gastos) + " USD");
        $("#tarifaPromedioDiaria").text(formatNumber(resultado.TarifaPromedioDiaria) + " USD");
    }
});

$.get({
    url: "helper/porcentajeOcupacion",
    success: function(datos) {
        var resultado = JSON.parse(datos);
        var html = "";

        $.each(resultado.porcentajes, function(i, e) {
            html += '<div class="col-main-2">' + e.NombrePropiedad + '</div>' +
            '<div class="col-main-2">' + e.Porcentaje + '%</div>';
        });

        porcentajePromedio = isNaN(resultado.promedio) ? Number(0).toFixed(2) : resultado.promedio;

        $("#porcentajes").empty();
        $("#porcentajes").append(html);
        $("#porcentajePromedio").text(porcentajePromedio + "%");
    }
});

$(document).ready(function() {
    $("#find_stats").click(function() {
        var init_date = $("#first_date_find").val();
        var finish_date = $("#second_date_find").val();
        var dataString = 'fechaInicial=' + init_date + '&fechaFinal=' + finish_date

        $.ajax({
            type: "GET",
            url: "helper/dashBoardFechas&" + dataString,
            data: dataString,
            success: function(datos) {
                var resultado = JSON.parse(datos);

                $("#ventas").text(formatNumber(resultado.Ventas) + " USD");
                $("#gastos").text(formatNumber(resultado.Gastos) + " USD");
                $("#tarifaPromedioDiaria").text(formatNumber(resultado.TarifaPromedioDiaria) + " USD");

                $(".date-box").text(init_date + " - " + finish_date);
            }
        });

        $.get({
            url: "helper/porcentajeOcupacionFechas&" + dataString,
            data: dataString,
            success: function(datos) {
                var resultado = JSON.parse(datos);
                var html = "";

                $.each(resultado.porcentajes, function(i, e) {
                    html += '<div class="col-main-2">' + e.NombrePropiedad + '</div>' +
                    '<div class="col-main-2">' + e.Porcentaje + '%</div>';
                });

                porcentajePromedio = isNaN(resultado.promedio) ? Number(0).toFixed(2) : resultado.promedio;

                $("#porcentajes").empty();
                $("#porcentajes").append(html);
                $("#porcentajePromedio").text(porcentajePromedio + "%");
            }
        });
    });
});
</script>
