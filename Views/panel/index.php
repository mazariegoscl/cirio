<!DOCTYPE html>
<html lang="en">
<head>
      <base href="<?=self::$base?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cabo BDS | Panel de Control</title>
    <script src="assets/js/jquery.js"></script>
		<link href="./assets/css/panel.css" rel="stylesheet">
</head>
<body style="background-color: #191919">
	<img src="assets/img/logo.svg" id="loginImg" />
    <form id="login">
			<label>Iniciar sesión</label>
        <input type="text" name="email" placeholder="Usuario" />
        <input type="password" name="pass" placeholder="Contraseñas" />
        <input type="submit" value="Entrar" />
    </form>
<?

if(isset($_SESSION["username"])) {
      echo $_SESSION["username"]["name"];
}

?>
    <div class="message"></div>

    <script>
    $(document).ready(function() {
        $("#login").submit(function(e) {
            e.preventDefault();
            var email = $("input[name='email']").val(),
            pass = $("input[name='pass']").val();
            $.ajax({
                type: "POST",
                url: "panel/login",
                data: {email:email, pass:pass},
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.error) {

                        $.each(data.error, function(key, val) {
                              $.each(data.error[key], function(key2) {
                                    console.log(
                                          `${key} ${data.error[key][key2]}`
                                    );
                              })
                        })

                  }else{
                        window.location.href = "panel";
                  }
                }
            });
        });
    });
</script>
</body>
</html>
