<!DOCTYPE html>
<html>
<head>
	<base href="<?=self::$base?>">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title>Cabo BDS · Home</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300" rel="stylesheet">
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<link rel="stylesheet" href="assets/css/styles.css">
	<script src="assets/js/vue.js"></script>
</head>
<body>
	<header>
		<div id="menu">
			<div>
				<span></span>
				<span></span>
			</div>
		</div>
		<nav>
			<ul>
				<li><a title="Cabo Bussinies Developmetnt Solutions" href="<?=$_SESSION['lang']?>/home"><?=HOME?></a></li>
				<li><a title="Know us, and come with us" href="<?=$_SESSION['lang']?>/about"><?=ABOUT?></a></li>
				<li class="logo"><img src="./assets/img/ico.svg" alt=""></li>
				<li><a title="Find the property perfect for you" href="<?=$_SESSION['lang']?>/estates"><?=ESTATES?></a></li>
				<li><a title="government permissions, legal solutions, architecture, design and more" href="<?=$_SESSION['lang']?>/services"><?=SERVICES?></a></li>
				<li><a href="tel:6121038971"><small><?=CONTACT_US?></small><br><b><?=PHONE?></b></a></li>
			</ul>
			<span id="changeLang"><a href="<?=$_SESSION['lang'] == 'es' ? " en " : " es " ?>"><?=LANG?></a></span>
		</nav>
	</header>

	<script type="text/javascript">

	$(document).ready(function() {

		$('#menu').click(function() {

			console.log($('#menu').hasClass('show'));

			if ( $('#menu').hasClass('show') ) {
				$('#menu').removeClass('show');
				$('nav').removeClass('show');
				$('.slogan').css('opacity', '1');
				$('body').css('overflow', 'auto');
			} else {
				console.log($('#menu').addClass('show'));
				$('#menu').addClass('show');
				$('nav').addClass('show');
				$('.slogan').css('opacity', '0');
				$('body').css('overflow', 'hidden');
			}
		});


	});

	</script>
