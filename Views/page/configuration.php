<div class="wrapper-charts">
    <h1 class="title-app">Cambiar contraseña</h1>
    <div class="wrapper-login" style="border-radius: 0 !important;">
        <form id="reset_password" style="text-align: center;">
            <div class="box-input">
                <label>Contraseña Anterior</label>
                <input name="oldPassword" type="password" />
            </div>

            <div class="box-input">
                <label>Nueva Contraseña</label>
                <input name="newPassword" type="password" />
            </div>

            <div class="box-input">
                <label>Repetir Nueva Contraseña</label>
                <input name="rNewPassword" type="password" />
            </div>
            <input type="submit" value="Cambiar" />
        </form>
    </div>
</div>
<script>
$(document).ready(function() {
    $("#reset_password").submit(function(e) {
        e.preventDefault();
        var dataString = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "users/resetePassword",
            data: dataString,
            success: function(data) {
                if(data.error) {
                    alert("Hubo un error al intentar actualizar tu contraseña, intentalo de nuevo.");
                } else {
                    alert("Contraseña actualizada correctamente.");
                }
            }
        });
    })
})
</script>
