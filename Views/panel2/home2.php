<!DOCTYPE html>
<html>
<head>
	<base href="<?=self::$base?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<meta charset="utf-8">
	<title></title>
	<link href="./assets/css/panel.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="assets/js/vue.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	<script src="//rubaxa.github.io/Sortable/Sortable.js"></script>
	<script type="text/javascript" src="./assets/js/drawer.js"></script>
	<link rel="stylesheet" href="https://e1016.github.io/JSwipe/drawer.min.css">
	<script type="text/javascript" src="assets/js/dropzone.js"></script>
	<link rel="stylesheet" href="assets/css/dropzone.css">

	<script type="text/javascript">
	let _projects = [{
		title: 'Las Fozas',
		short_description: 'Lorem ipsum dolor sit amet sanson',
		photo: 'https://i.pinimg.com/originals/b1/a8/8d/b1a88d8d31871588feb8e1b52c23c321.jpg',
		id: '0001'
	},{
		title: 'Dunas del Mar',
		short_description: 'Amet sanson dolor sit ipsum lorem',
		photo: 'https://i.pinimg.com/736x/47/b9/7e/47b97e62ef6f28ea4ae2861e01def86c--my-dream-house-dream-big.jpg',
		id: '0002'
	}];

	Dropzone.options.myAwesomeDropzonee = {
		autoProcessQueue: false,
		uploadMultiple: true,
		maxFiles: 4,
		maxFilesize: 5,
		addRemoveLinks: false,
		parallelUploads: 100,
		dictResponseError: 'Server not Configured',
		acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
		init:function(){
			var self = this;

			$("[name='send']").on("click", function() {
				self.processQueue(); // Tell Dropzone to process all queued files.
			});
			// config
			self.options.addRemoveLinks = true;
			self.options.dictRemoveFile = "Delete";
			var counter_files = self.files.length;
		}
	};

	Dropzone.options.myAwesomeDropzonee2 = {
		autoProcessQueue: false,
		uploadMultiple: true,
		maxFiles: 4,
		maxFilesize: 5,
		addRemoveLinks: false,
		parallelUploads: 100,
		dictResponseError: 'Server not Configured',
		acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
		init:function(){
			var self = this;

			$("[name='send']").on("click", function() {
				self.processQueue(); // Tell Dropzone to process all queued files.
			});
			// config
			self.options.addRemoveLinks = true;
			self.options.dictRemoveFile = "Delete";
			var counter_files = self.files.length;
		}
	};


	</script>
</head>
<body>
	<aside>
		<?php require_once('Views/panel/aside.php') ?>
	</aside>
	<main>
		<section id="search">
			<i class="material-icons">search</i>
			<input type="text" name="search" placeholder="buscar...">
		</section>

		<ul id="projects">

			<li v-for="(p, index) in projects" class="card">
				<md-settings>
					<span p_date>{{ p.date }}</span>
					<span p_description_es>{{ p.description_es }}</span>
					<span p_description_en>{{ p.description_en }}</span>
					<span p_id>{{ p.id }}</span>
					<span p_key>{{ p.key }}</span>
					<span p_property_type>{{ p.property_type }}</span>
					<span p_service_type>{{ p.service_type }}</span>
					<span p_status>{{ p.status }}</span>
					<span p_zone>{{ p.zone }}</span>

					<span p_name>{{ p.name }}</span>
					<span p_photo>images/projects/{{p.key}}/{{ p.photo }}</span>
					<span p_photo_path>{{ p.photo }}</span>
				</md-settings>
				<!--<figure v-bind:style="{ 'background-image': 'url(images/projects/' + p.key + '/' + p.photo + ')' }"></figure>-->

				<figure v-if="p.notPhoto === true || p.photo === ''" v-bind:style="{ 'background-image': 'url(images/default.png)'}"></figure>

				<figure v-else v-bind:style="{ 'background-image': 'url(images/projects/' + p.key + '/' + p.photo + ')' }"></figure>

				<div v-bind:data-id="p.id">
					<h3>{{ p.name }}</h3>
				</div>
				<i class="material-icons p-more">more_vert</i>
				<ul class="options">
					<li class="delete" @click="deleteFields(index, p)"><i class="material-icons">delete</i> BORRAR</li>
					<li class="edit" @click="updateFields(index, p)"><i class="material-icons">mode_edit</i> EDITAR</li>
					<li class="cancel"><i class="material-icons">cancel</i> CALCELAR</li>
				</ul>
			</li>

		</ul>
		<span class="md-modal"></span>
		<div id="addProjectForm">
			<div id="tabHeaders">
				<span trigger="t1" class="active">principal</span>
				<span trigger="t2">galería</span>
				<span trigger="t3">videos</span>
			</div>
			<div id="tabBodies">

				<div class="tab t1">
					<form name="initProject" id="initProject" method="POST" enctype="multipart/form-data">
						<input type="text" name="name" placeholder="Titulo" />
						<input type="hidden" name="id" value="0"/>
						<input type="hidden" name="key" value="0"/>
						<input type="hidden" name="photo_status" value="same"/>
						<div class="group">
							<input type="checkbox" name="demoproject" value="" id="demoproject">
							<label for="demoproject">No es necesaria mas información</label>
						</div>
						<hr>
						<div class="flex">
							<textarea name="description_es" placeholder="descripcion español..."></textarea>
							<textarea name="description_en" placeholder="english description..."></textarea>
						</div>
						<div id="thumbnail" style="background: white">
							<div id="erasePhoto">borrar</div>
						</div>
						<input type="file" name="photo" />
						<div class="flex">
							<div>
								<select id="property_type" name="property_type">
									<option value="1" selected>casa</option>
									<option value="2">terreno</option>
									<option value="3">departamento</option>
								</select>
								<select id="service_type" name="service_type">
									<hr>
									<option value="1" selected>venta</option>
									<option value="2">renta</option>
								</select>
							</div>
							<div>
								<select id="zone" name="zone">
									<option value="1" selected>La Paz BCS</option>
									<option value="2">Los Cabos</option>
									<option value="3">Loreto</option>
								</select>
								<select id="status" name="status">
									<option value="active" selected>activo</option>
									<option value="inactive">inactivo</option>
								</select>
							</div>
						</div>
						<div class="flex">
							<input type="submit" name="send" value="Guardar">
							<input type="button" name="send" value="Cancelar" id="cancel">
						</div>
					</form>
				</div>
				<!--type1-->
				<div class="tab t2" style="display: none;">
					<div class="flex">
						<div>
							<form method="post" class="dropzone" id="my-awesome-dropzonee" action="projects/saveGallery">
								<div class="dz-message" data-dz-message><span>Suba la foto principal aquí</span></div>
							</form>
						</div>
						<div>
							<form method="post" class="dropzone" id="my-awesome-dropzonee2" action="projects/saveVideos">
								<div class="dz-message" data-dz-message><span>Suba sus fotos aquí</span></div>
							</form>
						</div>
					</div>
				</div>
				<!--type2-->
				<div class="tab t3" style="display: none;">
				</div>
			</div>
		</div>

		<div id="newProject">
			<i class="material-icons">playlist_add</i>
		</div>
	</main>
</body>
</html>
<script>
statusMode = true;
$("#newProject").click(function() {
	statusMode = "project/save";
	$(".md-modal").show();
	$("#addProjectForm").show();
	$("#initProject")[0].reset();
	$("#erasePhoto").click();
	$("[name='photo_status']").val(0);
});

$('.md-modal').click(function() {
	$('#cancel').click();
});

$('#cancel').click(function() {
	$('.md-modal').css('display', 'none');
	$('#addProjectForm').css('display', 'none');
	$('#mdrawer_trgger').css('display', 'block');
});

var proj = new Vue({
	el: '#projects',
	data: {
		projects: null
	},
	methods: {
		deleteFields: function(index, el) {

			setTimeout(function() {
				$.ajax({
					type: 'POST',
					url: "project/delete",
					data: { id: el.id },
					success: function(data) {
						data = JSON.parse( data )
						if(data.error) {
							console.log(data.error);
						}else{
							console.log(data)
							console.log(index)
							proj.projects.splice( index, 1 );
						}
					}
				});
			}, 300);
		},
		updateFields: function(index, el) {
			this.globalIndex = index;
			this.globalId = el.id;
		}
	}
});

$("input[type='file']").change(function(e) {
	var file = e.target;
	var preview = document.getElementById('thumbnail');
	$("[name='photo_status']").val(0);
	if ( file.files[0] ) {
		var file    = file.files[0];
		var reader  = new FileReader();

		reader.onloadend = function () {
			preview.setAttribute('style', 'background-image: url(' + reader.result + '); padding-top: 40%;');
		}
		if (file) {
			reader.readAsDataURL(file);
		} else {
			preview.setAttribute('style', 'background-image: url('+'); padding-top: 0%;');
		}
	} else {
		preview.setAttribute('style', 'background-image: url("") padding-top: 0%;');
	}
});

$('#erasePhoto').click(function() {
	$('#thumbnail').css({
		'background-image': '',
		'padding-top': '0%'
	});
	$('[name=photo]').val(null)
	$('[name=photo]').attr('type', 'file')
	$("[name='photo_status']").val(0);
});

$("#initProject").submit(function(e) {
	e.preventDefault();
	$.ajax({
		type: "POST",
		url: statusMode,
		data: new FormData(this),
		processData: false,
		contentType: false,
		success: function(data) {
			var response = JSON.parse(data);
			response.key = response.directory;
			response.photo = response.photoGenerate;

			if ( statusMode === 'project/save' ) {
				if(response.error) {
					console.log("HAY ERROREs");
				}else{
					if(!proj.projects) {
						proj.projects = [];
					}
					proj.projects.push(response);
				}
			} else {
				var _currentId = $('#initProject').find('[name=id]').val();
				var currentIndxElement;
				/*proj.projects.forEach(function(el, indx) {
				if ( el.id === _currentId ) {
				currentIndxElement = indx;
			}
		});*/

		console.log(proj.globalId)
		console.log(proj.globalIndex)

		console.log(response)


		proj.projects[proj.globalIndex].description_en = response.description_en;
		proj.projects[proj.globalIndex].description_es = response.description_es;
		proj.projects[proj.globalIndex].name = response.name;

		proj.projects[proj.globalIndex].notPhoto = response.notPhoto;
		proj.projects[proj.globalIndex].photo = response.photo;
		proj.projects[proj.globalIndex].property_type = response.property_type;
		proj.projects[proj.globalIndex].service_type = response.service_type;
		proj.projects[proj.globalIndex].status = response.status;
		proj.projects[proj.globalIndex].zone = response.zone;
	}
}
});
});

$(document).ready(function() {
	$.ajax({
		type: "POST",
		url: "project/get",
		success: function(data) {
			setTimeout(function(){
				/*$('.p-more').unbind('click');
				$('.p-more').bind('click', function() {*/

				$('.cancel').click(function() {
					$(this).parent().remove();
				});

				$(".edit").click(function() {
					statusMode = "project/update";
					var settings = $(this).parent().siblings("md-settings");

					console.log(settings.children("[p_description_es]").text());
					$("[name='description_es']").val(settings.children("[p_description_es]").text());
					$("[name='description_en']").val(settings.children("[p_description_en]").text());
					$("[name='key']").val(settings.children("[p_key]").text());
					$("[name='id']").val(settings.children("[p_id]").text());
					$("[name='property_type'] option[value='"+settings.children("[p_property_type]").text()+"']").prop("selected", true);
					$("[name='service_type'] option[value='"+settings.children("[p_service_type]").text()+"']").prop("selected", true);
					$("[name='zone'] option[value='"+settings.children("[p_zone]").text()+"']").prop("selected", true);
					$("[name='name']").val(settings.children("[p_name]").text());
					$("[name='status']").val(settings.children("[p_status]").text());
					$("[name='photo_path']").val(settings.children("[p_photo_path]").text());

					$('[name=photo]').attr('type', 'hidden');
					$('[name=photo]').val(settings.children("[p_photo_path]").text())
					console.log(settings.children("[p_photo_path]").text())

					$("[name='photo_status']").val("same");

					if(settings.children("[p_photo_path]").text() == "") {
						$('#thumbnail').css({
							'background-image': 'url(images/default.png)',
						});
					}else{
						$('#thumbnail').css({
							'background-image': 'url(' +settings.children("[p_photo]").text() + ')',
						});
					}

					$('#thumbnail').css({
						'background-size': 'cover',
						'padding-top': '40%'
					});

					$(".md-modal").show();
					$("#addProjectForm").show();
					$("[trigger]").show();
				});
			},100);

			var response = JSON.parse(data);
			if(response.length > 0) {
				proj.projects = response;
			}
		}
	});
});
</script>
