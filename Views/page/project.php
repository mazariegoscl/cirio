<!DOCTYPE html>
<html>
<head>
	<base href="<?=self::$base?>">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title>Cabo BDS</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="./assets/css/project.css">
	<script type="text/javascript" src="./assets/js/jquery.js"></script>
	<script src="./assets/js/vue.js"></script>
</head>
<body>
	<header>
		<nav>
			<a href="<?=$_SESSION['lang']?>/estates"><?=GO_BACK?></a>
		</nav>
	</header>
	<main id="main">
		<h1>{{project.project_name}}</h1>
		<div id="gallery" class="gallery">
			<md-arrow>
				<i class="material-icons">arrow_forward</i>
			</md-arrow>
			<div class="photos">
				<ul id="photoCarousel">
					<li :style="`background-image: url(images/projects/${project.project_key}/${project.project_photo}), url(images/default.png)`" :onclick="(project.project_photo === '') ? 'return false' : 'displayPhoto(this)'" :data-bg="`images/projects/${project.project_key}/${project.project_photo}`"></li>

					<li v-for="img in imgs" :style="`background-image: url(images/projects/${project.project_key}/${img.image_name})`" :data-bg="`images/projects/${project.project_key}/${img.image_name}`" onclick="displayPhoto(this)"></li>

					<!--<li v-for="vid in vids" onclick="displayVideo(this)">
					<video style="width: 100%; height: 300px; " :src="`images/projects/${project.project_key}/${vid.video_name}`" :data-bg="`images/projects/${project.project_key}/${vid.video_name}`"></video>
				</li>-->

				<li style="display: block; height: auto; background-image: url('images/video.png'); background-size: 100px 100px; background-position: center; background-repeat: no-repeat;" v-for="vid in vids" onclick="displayVideo(this)">
					<h1 style="position: absolute;
					padding-left: 0;
					width: 100%;
					text-align: center;
					bottom: 20px;"><?=WATCH_VIDEO?></h1>
					<video :data-bg="`images/projects/${project.project_key}/${vid.video_name}`"></video>
				</li>
			</ul>
		</div>
		<p class="details">{{project.project_d_<?=$_SESSION["lang"]?>}}</p>
		<h2>${{project.project_price}}</h2>
		<hr>
		<h2 style="font-size: 45px;"><?=CHARACTERISTICS?></h2>
		<ul class="fields">
			<li if="filds" v-for="fl in filds">{{fl.fields_name_<?=$_SESSION["lang"]?>}} <span>{{fl.field_value}}</span></li>
		</ul>
		<div class="contact">
			<div><?=CONTACT_US?></div>
			<div><i style="opaicty: 0.5;" class="material-icons md-lights">arrow_forward</i></div>
			<a href="tel:6121038971">
				<div><i class="material-icons md-light">phone</i></div>
			</a>
		</div>
	</main>
</body>
</html>
<script>

function displayPhoto ( elem ) {

	elem = $(elem);
	console.log(elem.attr('data-bg'));
	console.log('trying launch pic');
	$('body').append(`<div id="photoModal" style="background-image: url('${ elem.attr('data-bg') }')"><i class="material-icons" id="close">close</i></div>`);
	$('#close').click(function() {
		$('#photoModal').remove();
	});
}

function displayVideo ( elem ) {
	console.log();
	elem = $(elem).find('video');
	console.log(elem.attr('data-bg'));
	console.log('trying launch pic');
	$('body').append(`<div id="photoModal">
	<video src="${ elem.attr('data-bg') }" controls="controls" style="object-fit: contain;"></video>
	<i class="material-icons" id="close">close</i>
	</div>`);

	$('#close').click(function() {
		$('#photoModal').remove();
	})
}

var project = new Vue({
	el:'#main',
	data: {
		project: null,
		imgs: null,
		vids: null,
		filds: null
	}
});

$(document).ready(function() {
	$.ajax({
		type: "POST",
		url: "<?=$_SESSION['lang']?>/getProject",
		data: {id: <?=$_GET['id']?>},
		success: function(data) {
			var response = JSON.parse(data);
			project.project = response.project;
			project.imgs = ( response.images ) ? response.images : null;
			project.vids = ( response.videos ) ? response.videos : null;
			project.filds = ( response.fields ) ? response.fields : null;

			setTimeout(function() {

				var len = 0;
				if ( project.imgs ) { len += project.imgs.length }
				if ( project.vids ) { len += project.vids.length }
				$('#photoCarousel').attr('style', `width: ${(530 * len)}px`);
			}, 200);
		}
	});
});
</script>
