<div class="wrapper-charts">
    <h1 class="title-app">Propiedades</h1>
    <div class="buttons-top">
        <button id="add_reservation" class="data-modal button-normal button-lblue" data-target="modal-reservaciones">Agregar Propiedad</button>
    </div>
    <div class="wrapper-box-content" style="margin-top: 50px;">
        <div id="exam"></div>
    </div>
</div>
<div class="modal" id="modal-reservaciones">
    <div class="close-button">
        <i class="fa fa-times"></i>
    </div>

    <div class="wrapper-modal">
        <div class="content-modal">
            <div class="wrapper-content-modal">
                <h3><i class="fa fa-home" style="color: #c94646;"></i> <span id='title-modal-reservation'>Nueva propiedad</span></h3>
                <form class="form-modal">
                    <div class="form-input">
                        <label><i class="fa fa-home"></i> Nombre: </label>
                        <input type="text" id="name" />
                    </div>

                    <div class="form-input">
                        <label><i class="fa fa-money-bill-alt"></i> Tarifa Base: </label>
                        <input id="rate" type="number" pattern="[0-9]*" />
                    </div>
                    <div class="form-input">
                        <label><i class="fa fa-money-bill-alt"></i> Tarifa Semanal: </label>
                        <input id="rate_weekly" type="number" pattern="[0-9]*" />
                    </div>
                    <div class="form-input">
                        <label><i class="fa fa-money-bill-alt"></i> Tarifa Mensual: </label>
                        <input id="rate_monthly" type="number" pattern="[0-9]*" />
                    </div>

                    <div class="submit-input">
                        <input id="insert_reservation" type="button" value="AGREGAR" class="button-normal button-lblue" />
                        <input id="update_reservation" type="button" value="ACTUALIZAR" class="button-normal button-lblue" style="display: none;" />
                        <input id="delete_reservation" type="button" value="ELIMINAR" class="button-normal button-lred" style="display: none;" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-tarifas">
    <div class="close-button">
        <i class="fa fa-times"></i>
    </div>

    <div class="wrapper-modal">
        <div class="content-modal" style="max-width: 600px;">
            <div class="wrapper-content-modal">
                <h3><i class="fa fa-calendar-alt" style="color: #c94646;"></i> <span id='title-modal-reservation'>Tarifas disponibles</span></h3>
                <div id="nueva_tarifa" style="float: right;" class="btn-plus data-modal" data-target="modal-nueva-tarifa"><i class="fa fa-plus data-modal"></i></div>

                <div class="table-main-inventory">
                    <div class="divRow">
                        <div class="divCell">
                            Fecha inicial
                        </div>
                        <div class="divCell">
                            Fecha Final
                        </div>
                        <div class="divCell">
                            Tarifa Base
                        </div>
                        <div class="divCell">
                            Tarifa Semanal
                        </div>
                        <div class="divCell">
                            Tarifa Mensual
                        </div>
                        <div class="divCell">

                        </div>
                    </div>
                    <div id="content_rates" class="content-tbl" style="display: table-row-group;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-nueva-tarifa">
    <div class="close-button">
        <i class="fa fa-times"></i>
    </div>

    <div class="wrapper-modal">
        <div class="content-modal">
            <div class="wrapper-content-modal">
                <h3><i class="fa fa-calendar-alt" style="color: #c94646;"></i> <span id='title-modal-rate'>Nueva Tarifa</span></h3>
                <form class="form-modal">
                    <div class="form-input">
                        <label><i class="fa fa-calendar-alt"></i> Fecha Inicial: </label>
                        <input id="property_rate_init_date" type="date" />
                    </div>
                    <div class="form-input">
                        <label><i class="fa fa-calendar-alt"></i> Fecha Final: </label>
                        <input id="property_rate_finish_date" type="date" />
                    </div>
                    <div class="form-input">
                        <label><i class="fa fa-money-bill-alt"></i> Tarifa Base: </label>
                        <input id="property_rate" type="number" pattern="[0-9]*" />
                    </div>
                    <div class="form-input">
                        <label><i class="fa fa-money-bill-alt"></i> Tarifa Semanal: </label>
                        <input id="property_rate_weekly" type="number" pattern="[0-9]*" />
                    </div>
                    <div class="form-input">
                        <label><i class="fa fa-money-bill-alt"></i> Tarifa Mensual: </label>
                        <input id="property_rate_monthly" type="number" pattern="[0-9]*" />
                    </div>

                    <div class="submit-input">
                        <input id="insert_tarifa" type="button" value="AGREGAR" class="button-normal button-lblue" />
                        <input id="update_tarifa" type="button" value="ACTUALIZAR" class="button-normal button-lblue" style="display: none;" />
                        <input id="delete_tarifa" type="button" value="ELIMINAR" class="button-normal button-lred" style="display: none;" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $("#insert_reservation").click(function() {
        var dataString = {
            name: $("#name").val(),
            rate: $("#rate").val(),
            rate_weekly: $("#rate_weekly").val(),
            rate_monthly: $("#rate_monthly").val()
        };
        $.ajax({
            type: "POST",
            url: "properties/save",
            data: dataString,
            success: function(data) {
                var data = JSON.parse(data);
                if(data.error) {
                    console.log(data);
                }else{
                    $("#exam").append(dataStructureReservation(data));
                    eventsActions();
                    $(".modal").hide();
                    $("body").css("overflow", "auto");
                }
            }
        });
    });

    $("#delete_reservation").click(function() {
        $.ajax({
            type: "DELETE",
            url: "properties/delete",
            data: {id: id_reservation},
            success: function(data) {
                var data = JSON.parse(data);
                if(data.error) {
                    console.log(data);
                }else{
                    $(".wrapper-box-reservation").eq(position_box).remove();
                    $(".modal").hide();
                    $("body").css("overflow", "auto");
                    console.log("SE ELIMINÓ");
                }
            }
        });
    });

    $("#update_reservation").click(function() {
        var dataString = {
            id: id_reservation,
            name: $("#name").val(),
            rate: $("#rate").val(),
            rate_weekly: $("#rate_weekly").val(),
            rate_monthly: $("#rate_monthly").val()
        };
        $.ajax({
            type: "PUT",
            url: "properties/update",
            data: dataString,
            success: function(data) {
                var data = JSON.parse(data);
                if(data.error) {
                    console.log(data);
                }else{
                    console.log(data);

                    $(".wrapper-box-reservation").eq(position_box).remove();
                    var who = dataStructureReservation(data);
                    position_box == 0 ? ($("#exam").prepend(dataStructureReservation(data))) : ($(who).insertAfter($(".wrapper-box-reservation").eq(position_box - 1)));
                    //$(who).insertAfter($(".wrapper-box-reservation").eq(actual_position));
                    eventsActions();
                    $(".modal").hide();
                    $("body").css("overflow", "auto");
                    console.log("SE ACTUALIZÓ");

                }
            }
        });
    });

    $("#insert_tarifa").click(function() {
        var dataString = {
            property: id_reservation,
            init_date: $("#property_rate_init_date").val(),
            finish_date: $("#property_rate_finish_date").val(),
            rate: $("#property_rate").val(),
            rate_weekly: $("#property_rate_weekly").val(),
            rate_monthly: $("#property_rate_monthly").val()
        };
        $.ajax({
            type: "POST",
            url: "rates/save",
            data: dataString,
            success: function(data) {
                var data = JSON.parse(data);
                if(data.error) {
                    console.log(data);
                }else{
                    $("#content_rates").append(dataStructureRate(data));
                    eventsActionsRates();
                    $("#modal-nueva-tarifa").hide();
                    $("body").css("overflow", "auto");
                }
            }
        });
    });

    $("#delete_tarifa").click(function() {
        $.ajax({
            type: "DELETE",
            url: "rates/delete",
            data: {id: id_rate},
            success: function(data) {
                var data = JSON.parse(data);
                if(data.error) {
                    console.log(data);
                }else{
                    $(".divRow").eq(position_box_rate).remove();
                    $("#modal-nueva-tarifa").hide();
                    $("body").css("overflow", "auto");
                    console.log("SE ELIMINÓ");
                }
            }
        });
    });

    $("#update_tarifa").click(function() {
        var dataString = {
            id: id_rate,
            property: id_reservation,
            init_date: $("#property_rate_init_date").val(),
            finish_date: $("#property_rate_finish_date").val(),
            rate: $("#property_rate").val(),
            rate_weekly: $("#property_rate_weekly").val(),
            rate_monthly: $("#property_rate_monthly").val()
        };
        $.ajax({
            type: "PUT",
            url: "rates/update",
            data: dataString,
            success: function(data) {
                var data = JSON.parse(data);
                if(data.error) {
                    console.log(data);
                }else{
                    console.log(data);

                    $("#content_rates .divRow").eq(position_box_rate).remove();
                    var who = dataStructureRate(data);
                    position_box_rate == 0 ? ($("#content_rates").prepend(dataStructureRate(data))) : ($(who).insertAfter($("#content_rates .divRow").eq(position_box_rate - 1)));
                    //$(who).insertAfter($(".wrapper-box-reservation").eq(actual_position));
                    eventsActionsRates();
                    $("#modal-nueva-tarifa").hide();
                    $("body").css("overflow", "auto");
                    console.log("SE ACTUALIZÓ");

                }
            }
        });
    });

    $("#add_reservation").click(function() {
        $("#name").val("");
        $("#rate").val("0");
        $("#rate_weekly").val("0");
        $("#rate_monthly").val("0");

        $("#insert_reservation").show();
        $("#update_reservation").hide();
        $("#delete_reservation").hide();
        $("#title-modal-reservation").text("Nueva propiedad");
    });

    $("#nueva_tarifa").click(function() {
        $("#property_rate_init_date").val(""),
        $("#property_rate_finish_date").val(""),
        $("#property_rate").val("0"),
        $("#property_rate_weekly").val("0"),
        $("#property_rate_monthly").val("0")

        $("#insert_tarifa").show();
        $("#update_tarifa").hide();
        $("#delete_tarifa").hide();
        $("#title-modal-rate").text("Nueva tarifa");
    });

    function setData(data) {
        id_reservation = Number(data.id);
        $("#name").val(data.name);
        $("#rate").val(data.rate);
        $("#rate_weekly").val(data.rate_weekly);
        $("#rate_monthly").val(data.rate_monthly);
    }

    function setDataRate(data) {
        id_rate = Number(data.id);
        $("#property_rate_init_date").val(data.init_date);
        $("#property_rate_finish_date").val(data.finish_date);
        $("#property_rate").val(data.rate);
        $("#property_rate_weekly").val(data.rate_weekly);
        $("#property_rate_monthly").val(data.rate_monthly);
    }

    function eventsActions() {
        data_modal();
        $(".edit-reservation").click(function() {
            var data = $(this).siblings('data');
            var reservation = data.attr("reservation");
            var parse = JSON.parse(reservation);
            setData(parse);

            position_box = $(this).parent('div').parent('div').parent('.wrapper-box-reservation').index();

            $("#insert_reservation").hide();
            $("#update_reservation").show();
            $("#delete_reservation").hide();
            $("#title-modal-reservation").text("Actualizar propiedad");
        });

        $(".delete-reservation").click(function() {
            var data = $(this).siblings('data');
            var reservation = data.attr("reservation");
            var parse = JSON.parse(reservation);
            setData(parse);

            position_box = $(this).parent('div').parent('div').parent('.wrapper-box-reservation').index();

            $("#insert_reservation").hide();
            $("#update_reservation").hide();
            $("#delete_reservation").show();
            $("#title-modal-reservation").text("Eliminar propiedad");
        });

        $(".rates-reservation").click(function() {
            var data = $(this).siblings('data');
            var reservation = data.attr("reservation");
            var parse = JSON.parse(reservation);
            id_reservation = parse.id;

            position_box = $(this).parent('div').parent('div').parent('.wrapper-box-reservation').index();

            $.ajax({
                type: "GET",
                url: "rates/getProperty&property=" + id_reservation,
                success: function(data) {
                    $("#content_rates").html("");
                    data = JSON.parse(data);
                    if(data.error) {
                        console.log(data);
                    } else {
                        console.log(data);
                        for (var i in data) {
                            console.log(data[i]);
                            $("#content_rates").append(dataStructureRate(data[i]));
                        }

                        eventsActionsRates();
                    }
                }
            })
        });
    }

    function eventsActionsRates() {
        data_modal();
        $(".edit-rate").click(function() {
            var data = $(this).siblings('data');
            var reservation = data.attr("rate");
            var parse = JSON.parse(reservation);
            setDataRate(parse);

            position_box_rate = $(this).parent('div').parent('div').index();

            $("#insert_tarifa").hide();
            $("#update_tarifa").show();
            $("#delete_tarifa").hide();
            $("#title-modal-rate").text("Actualizar tarifa");
        });

        $(".delete-rate").click(function() {
            var data = $(this).siblings('data');
            var reservation = data.attr("rate");
            var parse = JSON.parse(reservation);
            setDataRate(parse);

            position_box_rate = $(this).parent('div').parent('div').index();

            $("#insert_tarifa").hide();
            $("#update_tarifa").hide();
            $("#delete_tarifa").show();
            $("#title-modal-rate").text("Eliminar tarifa");
        });
    }

    function dataStructureReservation(data) {
        var dataStructureReservation = '<div class="wrapper-box-reservation"><div class="box-reservation" style="height: 150px;">';
        dataStructureReservation += '<div class="top-title"><i class="fa fa-home"></i> <span>' + data.name + '</span> <span> <small style="color: black;">Tarifa Base:</small> $' + data.rate + '</span><span> <small style="color: black;">Tarifa Semanal:</small> $' + data.rate_weekly + '</span><span> <small style="color: black;">Tarifa Mensual:</small> $' + data.rate_monthly + '</span></div>';
        dataStructureReservation += '<div class="res-actions">';
        dataStructureReservation += "<data reservation='" + JSON.stringify(data) + "'></data>";
        dataStructureReservation += '<i class="data-modal edit-reservation fa fa-edit" data-target="modal-reservaciones"></i>';
        dataStructureReservation += ' ';
        dataStructureReservation += '<i style="background-color: #d28de5; color: white;" class="data-modal rates-reservation fa fa-calendar-alt" data-target="modal-tarifas"></i>';
        dataStructureReservation += ' ';
        dataStructureReservation += '<i class="data-modal delete-reservation fa fa-trash" data-target="modal-reservaciones"></i>';
        dataStructureReservation += '</div>';
        dataStructureReservation += '</div>';
        dataStructureReservation += '</div>';
        return  dataStructureReservation;
    }

    function dataStructureRate(data) {
        var dataStructureRate = '<div class="divRow">';
        dataStructureRate += '<div class="divCell">';
        dataStructureRate += data.init_date;
        dataStructureRate += '</div>';
        dataStructureRate += '<div class="divCell">';
        dataStructureRate += data.finish_date;
        dataStructureRate += '</div>';
        dataStructureRate += '<div class="divCell">';
        dataStructureRate += data.rate;
        dataStructureRate += '</div>';
        dataStructureRate += '<div class="divCell">';
        dataStructureRate += data.rate_weekly;
        dataStructureRate += '</div>';
        dataStructureRate += '<div class="divCell">';
        dataStructureRate += data.rate_monthly;
        dataStructureRate += '</div>';
        dataStructureRate += '<div class="divCell" style="text-align: right;">';
        dataStructureRate += "<data rate='" + JSON.stringify(data) + "'></data>";
        dataStructureRate += '<i style="cursor: pointer; padding: 5px; color: #23bfa2; background-color: transparent;" class="data-modal edit-rate fa fa-edit" data-target="modal-nueva-tarifa"></i>';
        dataStructureRate += '<i style="cursor: pointer; padding: 5px; color: rgb(232, 98, 89); background-color: transparent;" class="data-modal delete-rate fa fa-trash" data-target="modal-nueva-tarifa"></i>';
        dataStructureRate += '</div>';
        dataStructureRate += '</div>';

        return dataStructureRate;
    }

    $.ajax({
        type: "GET",
        url: "properties/get",
        success: function(data) {
            console.log(data);
            var data = JSON.parse(data);
            if(data.error) {
                console.log(data);
            }else{
                for (var i in data) {
                    console.log(data[i]);
                    $("#exam").append(dataStructureReservation(data[i]));
                    // console.log(getReservations(data[i]));
                }
                eventsActions();
            }
        }
    })
});
</script>
