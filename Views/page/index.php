<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="src/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Cirio Panel</title>
</head>
<body>
    <header>
        <div class="title-header">EL CIRIO - Administración</div>
    </header>

<div class="wrapper-login">
    <h3>Iniciar sesión</h3>
    <form id="login-user" style="text-align: center;">
        <div class="box-input">
            <label>Usuario</label>
            <input type="text" />
        </div>

        <div class="box-input">
            <label>Contraseña</label>
            <input type="password" />
        </div>
        <input type="submit" value="Entrar" />
    </form>
</div>
<script>
$(document).ready(function() {
    $("form#login-user").submit(function(e) {
        e.preventDefault();
        window.location.href = "home.html";
    });
});
</script>
</body>
</html>
