<div class="wrapper-charts">
    <h1 class="title-app">Propiedades</h1>
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
            <button id="find_rates">Buscar</button>
        </div>
    </div>

    <div class="wrapper-box-content" style="margin-top: 50px;">
        <div id="exam"></div>
    </div>
</div>

<div class="modal" id="modal-tarifas">
    <div class="close-button">
        <i class="fa fa-times"></i>
    </div>

    <div class="wrapper-modal">
        <div class="content-modal" style="max-width: 350px;">
            <div class="wrapper-content-modal">
                <h3><i class="fa fa-calendar-alt" style="color: #c94646;"></i> <span id='title-modal-expense'>Historial de gasto</span></h3>
                <div id="nueva_tarifa" style="float: right;" class="btn-plus data-modal" data-target="modal-nueva-tarifa"><i class="fa fa-plus data-modal"></i></div>

                <div class="table-main-inventory">
                    <div class="divRow">
                        <div class="divCell">
                            Fecha
                        </div>
                        <div class="divCell">
                            Cantidad
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
                <h3><i class="fa fa-calendar-alt" style="color: #c94646;"></i> <span id='title-modal-rate'>Nuevo gasto</span></h3>
                <form class="form-modal">

                    <div class="form-input">
                        <label><i class="fa fa-money-bill-alt"></i> Cantidad: </label>
                        <input id="property_quantity" type="number" pattern="[0-9]*" />
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
            id_property: id_property,
            expense_property: id_reservation,
            quantity: $("#property_quantity").val()
        };
        $.ajax({
            type: "POST",
            url: "expensesProperty/save",
            data: dataString,
            success: function(data) {
                var data = JSON.parse(data);
                if(data.error) {
                    console.log(data);
                }else{
                    $("#content_rates").append(dataStructureRate(data.expense));
                    $(".wrapper-box-reservation").eq(position_box).remove();




                    position_box == 0 ? ($("#exam").prepend(dataStructureReservation2(data))) : ($(dataStructureReservation2(data)).insertAfter($(".wrapper-box-reservation").eq(position_box - 1)));
                    eventsActionsRates();
                    eventsActions();
                    $("#modal-nueva-tarifa").hide();
                    $("body").css("overflow", "auto");
                }
            }
        });
    });

    $("#delete_tarifa").click(function() {
        $.ajax({
            type: "DELETE",
            url: "expensesProperty/delete",
            data: {id: id_rate, id_property: id_property},
            success: function(data) {
                var data = JSON.parse(data);
                if(data.error) {
                    console.log(data);
                }else{
                    $("#content_rates .divRow").eq(position_box_rate).remove();
                    $(".wrapper-box-reservation").eq(position_box).remove();




                    position_box == 0 ? ($("#exam").prepend(dataStructureReservation2(data))) : ($(dataStructureReservation2(data)).insertAfter($(".wrapper-box-reservation").eq(position_box - 1)));
                    eventsActionsRates();
                    eventsActions();
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
            id_property: id_property,
            expense_property: id_reservation,
            quantity: $("#property_quantity").val()
        };
        $.ajax({
            type: "PUT",
            url: "expensesProperty/update",
            data: dataString,
            success: function(data) {
                var data = JSON.parse(data);
                if(data.error) {
                    console.log(data);
                }else{
                    console.log(data);

                    $("#content_rates .divRow").eq(position_box_rate).remove();
                    $(".wrapper-box-reservation").eq(position_box).remove();




                    position_box == 0 ? ($("#exam").prepend(dataStructureReservation2(data))) : ($(dataStructureReservation2(data)).insertAfter($(".wrapper-box-reservation").eq(position_box - 1)));

                    var who = dataStructureRate(data.expense);
                    position_box_rate == 0 ? ($("#content_rates").prepend(dataStructureRate(data.expense))) : ($(who).insertAfter($("#content_rates .divRow").eq(position_box_rate - 1)));
                    //$(who).insertAfter($(".wrapper-box-reservation").eq(actual_position));
                    eventsActionsRates();
                    eventsActions();
                    // eventsActions();
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
        $("#property_quantity").val(""),

        $("#insert_tarifa").show();
        $("#update_tarifa").hide();
        $("#delete_tarifa").hide();
        $("#title-modal-rate").text("Nuevo Gasto");
    });

    function setData(data) {
        id_reservation = Number(data.property.id);
        $("#name").val(data.name);
        $("#rate").val(data.rate);
        $("#rate_weekly").val(data.rate_weekly);
        $("#rate_monthly").val(data.rate_monthly);
    }

    function setDataRate(data) {
        id_rate = Number(data.id);
        $("#property_quantity").val(data.quantity);
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
            var reservation = data.attr("rate");
            var parse = JSON.parse(reservation);
            id_reservation = parse.id;
            id_property = parse.id_property;

            position_box = $(this).parent('div').parent('div').parent('div').parent('div').parent('div').parent('.wrapper-box-reservation').index();
            $("#title-modal-expense").text("Historial de " + parse.name_expense + "  (" + parse.name + ")");
            $.ajax({
                type: "GET",
                url: "expensesProperty/getId&property=" + id_reservation,
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
            console.log("PTM");
            setDataRate(parse);

            position_box_rate = $(this).parent('div').parent('div').index();

            $("#insert_tarifa").hide();
            $("#update_tarifa").show();
            $("#delete_tarifa").hide();
            $("#title-modal-rate").text("Actualizar Gasto");
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
            $("#title-modal-rate").text("Eliminar Gasto");
        });
    }

    function dataStructureReservation(data) {
        var dataStructureReservation = '';
        for (var i in data) {
            console.log(data[i]);
            dataStructureReservation = '<div style="vertical-align: top;" class="wrapper-box-reservation"><div class="box-reservation" style="display: table; height: auto; vertical-align: top;">';
            dataStructureReservation += '<div class="top-title"><i class="fa fa-home"></i> <span>' + data[i].property.name + '</span></div>';
            if(data[i].expenses) {
                dataStructureReservation += '<div style="display: table; width: 100%;"><div id="content_expenses" class="content-tbl" style="display: table-row-group;">';


                for (var u in data[i].expenses) {
                    console.log(data[i].expenses[u].name_expense + " " + data[i].expenses[u].quantity);

                    dataStructureReservation += '<div class="divRow rowNotcolor">';
                    dataStructureReservation += '<div class="divCell cellNotColor">';
                    dataStructureReservation += data[i].expenses[u].name_expense;
                    dataStructureReservation += '</div>';
                    dataStructureReservation += '<div class="divCell cellNotColor">';
                    dataStructureReservation += '$' + data[i].expenses[u].quantity;
                    dataStructureReservation += '</div>';
                    dataStructureReservation += '<div class="divCell cellNotColor" style="text-align: right;">';
                    dataStructureReservation += "<data rate='" + JSON.stringify(data[i].expenses[u]) + "'></data>";
                    dataStructureReservation += '<i style="cursor: pointer; padding: 5px; color: #23bfa2; background-color: transparent;" class="data-modal rates-reservation fa fa-table" data-target="modal-tarifas"></i>';
                    dataStructureReservation += '</div>';
                    dataStructureReservation += '</div>';

                }
                dataStructureReservation += '</div></div>';

            }
            dataStructureReservation += '</div>';
            dataStructureReservation += '</div>';
            $("#exam").append(dataStructureReservation);
        }
    }

    function dataStructureReservation2(data) {
        //id_rate = data.property.id;
        var dataStructureReservation = '';
        dataStructureReservation = '<div style="vertical-align: top;" class="wrapper-box-reservation"><div class="box-reservation" style="display: table; height: auto; vertical-align: top;">';
        dataStructureReservation += '<div class="top-title"><i class="fa fa-home"></i> <span>' + data.property.name + '</span></div>';
        if(data.expenses) {
            dataStructureReservation += '<div style="display: table; width: 100%;"><div id="content_expenses" class="content-tbl" style="display: table-row-group;">';


            for (var u in data.expenses) {
                console.log(data.expenses[u].name_expense + " " + data.expenses[u].quantity);

                dataStructureReservation += '<div class="divRow rowNotcolor">';
                dataStructureReservation += '<div class="divCell cellNotColor">';
                dataStructureReservation += data.expenses[u].name_expense;
                dataStructureReservation += '</div>';
                dataStructureReservation += '<div class="divCell cellNotColor">';
                dataStructureReservation += '$' + data.expenses[u].quantity;
                dataStructureReservation += '</div>';
                dataStructureReservation += '<div class="divCell cellNotColor" style="text-align: right;">';
                dataStructureReservation += "<data rate='" + JSON.stringify(data.expenses[u]) + "'></data>";
                dataStructureReservation += '<i style="cursor: pointer; padding: 5px; color: #23bfa2; background-color: transparent;" class="data-modal rates-reservation fa fa-table" data-target="modal-tarifas"></i>';
                dataStructureReservation += '</div>';
                dataStructureReservation += '</div>';

            }
            dataStructureReservation += '</div></div>';

        }
        dataStructureReservation += '</div>';
        dataStructureReservation += '</div>';
        return dataStructureReservation;
    }

    function dataStructureRate(data) {
        var dataStructureRate = '<div class="divRow">';
        dataStructureRate += '<div class="divCell">';
        dataStructureRate += data.date;
        dataStructureRate += '</div>';
        dataStructureRate += '<div class="divCell">';
        dataStructureRate += data.quantity;
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
        url: "expensesProperty/getProperty",
        success: function(data) {
            // console.log(data);
            var data = JSON.parse(data);
            if(data.error) {
                // console.log(data);
            }else{
                dataStructureReservation(data);
                eventsActions();
            }
        }
    });

    $("#find_rates").click(function() {
        var init_date = $("#first_date_find").val();
        var finish_date = $("#second_date_find").val();
        var dataString = 'init_date=' + init_date + '&finish_date=' + finish_date
        $.ajax({
            type: "GET",
            url: "expensesProperty/getPropertyDates&" + dataString,
            success: function(data) {
                // console.log(data);
                var data = JSON.parse(data);
                if(data.error) {
                    // console.log(data);
                }else{
                    $("#exam").html("");
                    dataStructureReservation(data);
                    eventsActions();
                }
            }
        })
    })
});
</script>
