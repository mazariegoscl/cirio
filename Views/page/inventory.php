<div class="wrapper-charts">
    <h1 class="title-app">Inventario Variable</h1>
    <div class="buttons-top">
        <button id="add_reservation" class="data-modal button-normal button-lblue" data-target="modal-reservaciones">Agregar Inventario</button>
    </div>
    <div class="box-style0">
        <div class="wrapper-box-content">
            <h3 class="title-box h3-style2">
                <span>Nombre</span>
                <span style="float: right;">Existencia</span>
            </h3>
            <hr />
            <div class="table-main-inventory">
                <!-- contenido inventario -->
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
                        <label><i class="fa fa-home"></i> Nombre: </label>
                        <input type="text" id="name" />
                    </div>

                    <div class="form-input">
                        <label><i class="fa fa-money-bill-alt"></i> Cantidad: </label>
                        <input id="quantity" type="number" pattern="[0-9]*" />
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
    $("#insert_reservation").click(function() {
        var dataString = {
            name: $("#name").val(),
            quantity: $("#quantity").val()
        };
        $.ajax({
            type: "POST",
            url: "inventory/save",
            data: dataString,
            success: function(data) {
                var data = JSON.parse(data);
                if(data.error) {
                    console.log(data);
                }else{
                    $(".table-main-inventory").append(dataStructureReservation(data));
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
            url: "inventory/delete",
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
            name: $("#name").val(),
            quantity: $("#quantity").val()
        };
        $.ajax({
            type: "PUT",
            url: "inventory/update",
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
        dataStructureReservation += '<span class="quantity-inventory">' + data.quantity + '</span>';
        dataStructureReservation += '<i style="background: none !important;" class="data-modal edit-reservation fa fa-edit" data-target="modal-reservaciones"></i>';
        dataStructureReservation += ' ';
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
        });
    }

    function setData(data) {
        id_reservation = Number(data.id);
        $("#name").val(data.name);
        $("#quantity").val(data.quantity);
    }


    $("#add_reservation").click(function() {
        $("#name").val("");
        $("#quantity").val("");

        $("#insert_reservation").show();
        $("#update_reservation").hide();
        $("#delete_reservation").hide();
        $("#title-modal-reservation").text("Nuevo artículo");
    });

    $.ajax({
        type: "GET",
        url: "inventory/get",
        success: function(data) {
            console.log(data);
            var data = JSON.parse(data);
            if(data.error) {
                console.log(data);
            }else{
            for (var i in data) {
                console.log(data[i]);
                $(".table-main-inventory").append(dataStructureReservation(data[i]));
                // console.log(getReservations(data[i]));
            }
            eventsActions();
        }
        }
    })
});
</script>
