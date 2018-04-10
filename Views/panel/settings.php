
<!DOCTYPE html>
<html>
	<head>
		<?=require_once("Views/panel/head.php");?>
		<meta charset="utf-8">
		<title>Ajustes</title>
	</head>
	<body class="settings">
		<aside class="">
			<?=require_once("Views/panel/aside.php");?>
		</aside>
		<main>
			<label for="username">USUARIO</label>
			<input type="text" name="username" id="username">
			<label for="username">CONTRASEÑA</label>
			<input type="password" name="password" id="password">
			<label for="username">CONFIRMAR CONTRASEÑA</label>
			<input type="password" name="password_confirm" id="password_confirm">
			<hr>
			<p>Establezca el numero de proyectos que se mostrarán en la página principal</p>
			<input type="number" name="n_projects">
			<button id="submitData">GUARDAR</button>
		</main>
	</body>
</html>

<script type="text/javascript">
$(document).ready(function() {

	$.ajax({
		url: //url del get
		type: 'POST',
		success: function(res) {
			res = JSON.parse(res);
			$('#username').val(res.username);
			$('[name=n_projects]').val(res.n_projects);
		}
	});

	$('#submitData').click(function() {

		if ($('#password').val() === $('#password_confirm').val()) {
			$.ajax({
				url: //url del update
				type: 'POST',
				success: function(res) {
					res = JSON.parse(res);
					if (res.error) {
						// Aquí va el algoritmo de validacion que hice en el login
						// junto con toasts.err('MENSAJE DE ERROR');
					} else {
						// junto con toasts.err('GUARDADO CORRECTAMENTE');
					}
				}
			});
		} else {
			// toasts.err('Las contraseñas no coinciden');
		}
	});
});
</script>
