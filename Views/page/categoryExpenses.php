<div class="wrapper-charts">
    <h1 class="title-app">Categoría de gastos</h1>
    <div class="buttons-top">
        <button id="add_reservation" class="data-modal button-normal button-lblue" data-target="modal-reservaciones" disabled>Agregar Categoría-gasto</button>
    </div>
    <div class="box-style0">
        <div class="custom-select0" style="width:250px;">
            <select id="property-list" class="select-default">
                <option value="">Seleccionar una propiedad</option>
            </select>
        </div>

        <div  id="content-inventory-property">
            <div class="wrapper-box-content">
                <h3 class="title-box h3-style2">
                    <span>Nombre</span>
                    <span style="float: right;"></span>
                </h3>
                <hr />
                <div class="table-main-inventory">
                    <!-- contenido inventario -->
                </div>
            </div>
        </div>
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
                        <label> Nombre: </label>
                        <select id="categories-list"></select>
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

<script>
$(document).ready(function() {

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
                    $("#property-list").append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                    // console.log(getReservations(data[i]));//
                }
            }
        }
    });

    $("#property-list").change(function() {
        console.log("CAMBIANDO");
        id_property = $(this).val();

        if($(this).val() == "") {
            $("#add_reservation").prop("disabled", true);
            $("#add_reservation").css({"opacity": "0.5", "cursor": "not-allowed"});
            $(".table-main-inventory").html("");
        } else {
            $("#add_reservation").prop("disabled", false);
            $("#add_reservation").css({"opacity": "1", "cursor": "pointer"});

            var dataString = 'property=' + id_property
            $.ajax({
                type: "GET",
                url: "categoryExpensesProperty/getId&" + dataString,
                data: dataString,
                success: function(data) {
                    $(".table-main-inventory").html("");
                    console.log(data);
                    var data = JSON.parse(data);
                    if(data.error) {
                        console.log(data);
                    } else {
                        for (var i in data) {
                            console.log(data[i]);
                            $(".table-main-inventory").append(dataStructureReservation(data[i]));
                            // console.log(getReservations(data[i]));
                        }
                        eventsActions();
                    }
                }
            });
        }
    });

    $("#insert_reservation").click(function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var dataString = {
            property: id_property,
            expense: $("#categories-list").val()
        };
        $.ajax({
            type: "POST",
            url: "categoryExpensesProperty/save",
            data: dataString,
            beforeSend: function() {
                $("#insert_reservation").prop("disabled", true);
            },
            success: function(data) {
                var data = JSON.parse(data);
                if(data.error) {
                    console.log(data);
                }else{
                    console.log(data);
                    $(".table-main-inventory").append(dataStructureReservation(data[0]));
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
            url: "categoryExpensesProperty/delete",
            data: {id: id_reservation},
            success: function(data) {
                var data = JSON.parse(data);
                if(data.error) {
                    console.log(data);
                }else{
                    $(".wrapper-content-2").eq(position_box).remove();
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
            property: id_property,
            name: $("#name").val(),
            quantity: $("#quantity").val()
        };
        $.ajax({
            type: "PUT",
            url: "categoryExpensesProperty/update",
            data: dataString,
            success: function(data) {
                var data = JSON.parse(data);
                if(data.error) {
                    console.log(data);
                }else{
                    console.log(data);

                    $(".wrapper-content-2").eq(position_box).remove();
                    var who = dataStructureReservation(data);
                    position_box == 0 ? ($(".table-main-inventory").prepend(dataStructureReservation(data))) : ($(who).insertAfter($(".wrapper-content-2").eq(position_box - 1)));
                    //$(who).insertAfter($(".wrapper-box-reservation").eq(actual_position));
                    eventsActions();
                    $(".modal").hide();
                    $("body").css("overflow", "auto");
                    console.log("SE ACTUALIZÓ");

                }
            }
        });
    });

    function dataStructureReservation(data) {
        var dataStructureReservation = '<div class="wrapper-content-2">';
        dataStructureReservation += '<div class="col-main-inventory-1">';
        dataStructureReservation +=  data.name
        dataStructureReservation += '</div>';
        dataStructureReservation += '<div class="col-main-inventory-2">';
        dataStructureReservation += "<data reservation='" + JSON.stringify(data) + "'></data>";
        dataStructureReservation += '<i style="background: none !important;" class="data-modal delete-reservation fa fa-trash" data-target="modal-reservaciones"></i>';
        dataStructureReservation += '</div>';
        dataStructureReservation += '</div>';
        return  dataStructureReservation;
    }

    function eventsActions() {
        data_modal();
        $(".edit-reservation").click(function() {
            var data = $(this).siblings('data');
            var reservation = data.attr("reservation");
            var parse = JSON.parse(reservation);
            setData(parse);

            position_box = $(this).parent('div').parent('.wrapper-content-2').index();

            $("#insert_reservation").hide();
            $("#update_reservation").show();
            $("#delete_reservation").hide();
            $("#title-modal-reservation").text("Actualizar artículo");
        });

        $(".delete-reservation").click(function() {
            var data = $(this).siblings('data');
            var reservation = data.attr("reservation");
            var parse = JSON.parse(reservation);
            setData(parse);

            position_box = $(this).parent('div').parent('.wrapper-content-2').index();

            $("#insert_reservation").hide();
            $("#update_reservation").hide();
            $("#delete_reservation").show();
            $("#title-modal-reservation").text("Eliminar artículo");
            $("#categories-list").html("");
            $("#categories-list").append("<option value='" + parse.id + "'>" + parse.name + "</option>");
        });
    }

    function setData(data) {
        id_reservation = Number(data.id);
        $("#name").val(data.name);
        $("#quantity").val(data.quantity);
    }


    $("#add_reservation").click(function() {
        $("#insert_reservation").prop("disabled", false);
        $("#name").val("");
        $("#quantity").val("");

        $("#insert_reservation").show();
        $("#update_reservation").hide();
        $("#delete_reservation").hide();
        $("#title-modal-reservation").text("Nuevo artículo")

        $.ajax({
            type: "GET",
            url: "categoryExpensesProperty/getEP&property=" + id_property,
            success: function(data) {
                $("#categories-list").html("");
                data = JSON.parse(data);
                if(data.error) {
                    console.log(data);
                    $("#categories-list").append("<option value=''>No hay categórias disponiblesr</option>");
                } else {
                    for(var i in data) {
                        $("#categories-list").append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                    }
                }
            }
        })
    });

});
</script>
