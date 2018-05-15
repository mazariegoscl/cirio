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
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>-->
	<style>
	.sortable-chosen.sortable-ghost {
		opacity: 0;
	}
	.sortable-fallback {
		opacity: 1 !important;
	}
</style>
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
				<i class="material-icons move-project">open_with</i>
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
					<span p_price>{{ p.price }}</span>
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
				<div>
					<i class="material-icons p-more">more_vert</i>
					<ul class="options">
						<li class="delete" @click="deleteFields(index, p)"><i class="material-icons">delete</i> BORRAR</li>
						<li class="edit" @click="updateFields(index, p)"><i class="material-icons">mode_edit</i> EDITAR</li>
						<li class="cancel"><i class="material-icons">cancel</i> CALCELAR</li>
					</ul>
				</div>
			</li>

		</ul>
		<span class="md-modal"></span>
		<div id="addProjectForm">
			<div id="tabHeaders">
				<span trigger="t1" class="active">principal</span>
				<span trigger="t2">galería</span>
				<span trigger="t3">videos</span>
				<span trigger="t4">extras</span>
			</div>
			<div id="tabBodies">

				<div class="tab t1">
					<form name="initProject" id="initProject" method="POST" enctype="multipart/form-data">
						<input type="text" name="name" placeholder="Titulo" />
						<input type="hidden" name="id" value="0"/>
						<input type="hidden" name="key" value="0"/>
						<input type="hidden" name="photo_status" value="same"/>
						<!--div class="group">
						<input type="checkbox" name="demoproject" value="" id="demoproject">
						<label for="demoproject">No es necesaria mas información</label>
					</div-->
					<hr>
					<div class="flex">
						<textarea name="description_es" placeholder="descripcion español..."></textarea>
						<textarea name="description_en" placeholder="english description..."></textarea>
					</div>
					<div id="thumbnail" style="background: white">
						<div id="erasePhoto">borrar</div>
					</div>
					<input style="display: none;" type="file" name="photo" id="photo" accept='image/*' />
					<label for="photo">Elige un archivo...</label>
					<div class="flex">
						<div>
							<label for="property_type">tipo de propiedad</label>
							<select id="property_type" name="property_type">
								<option value="" selected>-- tipo de propiedad --</option>
								<option v-for="(pr, index) in properties" v-if="pr.status === 'active'" :value="index + 1">{{pr.name_es}} / {{pr.name_en}}</option>
								<!--<option value="1" selected>casa</option>
								<option value="2">terreno</option>
								<option value="3">departamento</option>-->
							</select>
							<label for="property_type">tipo de service</label>
							<select id="service_type" name="service_type">
								<option value="" selected>-- tipo un servicio --</option>
								<option v-for="(se, index) in services" v-if="se.status === 'active'" :value="index + 1">{{se.name_es}} / {{se.name_en}}</option>
								<!--<option value="2">renta</option>-->
							</select>
						</div>
						<div>
							<label for="property_type">zona</label>
							<select id="zone" name="zone">
								<option value="" selected>-- una zona--</option>
								<option v-for="(zo, index) in zones" v-if="zo.status === 'active'" :value="index + 1">{{zo.name}}</option>
							</select>
							<label for="property_type">estatus del proyecto</label>
							<select id="status" name="status">
								<option value="active" selected>activo</option>
								<option value="inactive">inactivo</option>
							</select>
						</div>
					</div>
					<label for="price">price: $</label>
					<input type="text" name="price" value="" id="price">
					<div class="flex">
						<input type="submit" name="send" value="Guardar">
						<input type="button" name="send" value="Cancelar" id="cancel">
					</div>
				</form>
			</div>
			<!--type1-->
			<div class="tab t2" style="display: none;">
				<div>

					<div id="imageLists">
						<li v-for="(el, index) in images" :style="'background-image: url(images/projects/' + projectKey + '/' + el.name + '), url(images/default.png)'">
							<i class="material-icons" @click="deleteImage(el.id, index)">close</i>
						</li> <!--ANCHOR-->
					</div>

					<form method="post" class="dropzone" id="my-awesome-dropzone-gallery" action="project/saveImages">
						<div class="dz-message" data-dz-message><span>Click para subir fotos</span></div>
						<input type="hidden" id="id_project_images" name="id_project" value="0"/>
						<input type="hidden" id="key_project_images" name="key_project" value="0"/>
					</form>
					<button id="uploadImages"><i class="material-icons">file_upload</i> SUBIR IMÁGENES</button>

					<div id="addImage">
						nuevo
					</div>

				</div>
			</div>
			<!--type2-->
			<div class="tab t3" style="display: none;">

				<div id="videoLists">
					<li v-for="(el, index) in videos">
						<i class="material-icons" @click="deleteVideo(el.id, index)">close</i>
						<video controls style="width: 100%;" :src="'images/projects/' + projectKey + '/' + el.name">
						</video>  <!--ANCHOR-->
					</li>
				</div>

				<form method="post" class="dropzone" id="my-awesome-dropzone-videos" action="project/saveVideos">
					<div class="dz-message" data-dz-message><span>Click para subir videos</span></div>
					<input type="hidden" id="id_project_videos" name="id_project" value="0"/>
					<input type="hidden" id="key_project_videos" name="key_project" value="0"/>
				</form>
				<button id="uploadVideos"><i class="material-icons">file_upload</i> SUBIR VIDEOS</button>

				<div id="addVideo">
					nuevo
				</div>

			</div>
			<div class="tab t4" style="display: none;" id="extraFieldsRef">
				<button id="editCustomFields">EDITAR CAMPOS</button>
				<div id="currentFields">
					<h4>Elementos actuales</h4>
					<ul>
						<li v-for="(c, index) in currentFields">
							<span @click="deleteCurrentField(c, index)"><i class="material-icons">delete</i></span>
							<span>{{c.name_en}} | {{c.name_es}}</span>
							<span class="val">{{c.value}}</span>
						</li>
					</ul>
				</div>
				<div id="additive">
					<div class="options">
						<h4>Elementos a elegir</h4>
						<ul>
							<li v-for="(o, index) in optionFields">
								<span @click="prepareField(o, index)"><i class="material-icons" style="color: #2196f3;">add_circle_outline</i></span>
								<span>{{o.name_en}} | {{o.name_es}}</span>
							</li>
						</ul>
					</div>
					<div class="prepares">
						<h4>Elementos por postear</h4>
						<ul>
							<li v-for="(p, index) in prepareFields">
								<span @click="returnPrepared(p, index)"><i class="material-icons">remove_circle_outline</i></span>
								<span>{{p.name_en}} | {{p.name_es}}</span>
								<span><input v-model="p.value" type="text" placeholder="valor..."/></span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="newProject">
		<i class="material-icons">playlist_add</i>
	</div>

	<div id="toasts">
		<span v-for="t in toast" :style="'background-color: ' + t.c + ';'">{{ t.l }}</span>
	</div>
	<div id="loadingScreen">
		<img width="60" src="assets/img/spinner.gif">
	</div>
</main>
</body>
</html>
<script>

var customFields = new Vue({
	el: '#extraFieldsRef',
	data: {
		currentFields: [{name_en: 'Current', name_es: 'Actual', val: '4'}],
		optionFields: [{name_en: 'Optional', name_es: 'Opcional'}],
		prepareFields: null
	},
	methods: {
		deleteCurrentField: function(ob, index) {

			console.log(ob);
			$.ajax({
				type: 'POST',
				url: 'projectFields/delete',
				data: {
					id: ob.id_pfield
				},
				success: function(res) {

					res = JSON.parse(res);

					toasts.ok('Campo eliminado')
					if (customFields.optionFields === null) {
						customFields.optionFields = []
					}

					if (customFields.currentFields === null) {
						customFields.currentFields = []
					}
					customFields.optionFields.push(ob);
					customFields.currentFields.splice(index, 1);
				}
			});
		},
		prepareField: function(fld, index) {
			if (this.prepareFields === null) {
				this.prepareFields = [];
			}
			fld.value = '';
			this.optionFields.splice(index, 1);
			this.prepareFields.push(fld);
		},
		returnPrepared: function(fld, index) {
			if (this.optionFields === null) {
				this.optionFields = [];
			}
			this.prepareFields.splice(index, 1);
			this.optionFields.push(fld);
		},
		loadCurrentFields() {
			$.ajax({
				type: 'POST',
				url: 'projectFields/get',
				data: {
					id: id_project,
					param: 1,
				},
				success: function(res) {
					res = JSON.parse(res);
					console.log(res);
					customFields.currentFields = (res.length > 0) ? res : null;
				}
			})
		},
		loadMissingFields() {
			$.ajax({
				type: 'POST',
				url: 'projectFields/get',
				data: {
					id: id_project,
					param: 0,
				},
				success: function(res) {
					res = JSON.parse(res);
					console.log(res);
					customFields.optionFields = (res.length > 0) ? res : null;
				}
			})
		}
	}
});

$('#editCustomFields').click(function() {
	if ($(this).text() === 'EDITAR CAMPOS') {
		$(this).text('GUARDAR CAMBIOS');
		$('#currentFields').hide();
		$('#additive').show();
	} else {

		var bundle = {
			id_project: id_project,
			fields: customFields.prepareFields
		}

		$.ajax({
			type: 'POST',
			url: 'projectFields/save',
			data: bundle,
			success: function(res) {
				console.log(res);
				if (!res.error) {
					setTimeout(function() {
						customFields.loadCurrentFields();
						customFields.loadMissingFields();
						customFields.prepareFields = null;
					}, 100);
					$('#editCustomFields').text('EDITAR CAMPOS');
					$('#currentFields').show();
					$('#additive').hide();
				}
			}
		});
	}
});

var toasts = new Vue ({
	el: '#toasts',
	data: {
		toast: null
	},
	methods: {
		ok: function( par ) {
			if ( this.toast === null ) {
				this.toast = []
			}
			this.toast.push({
				l: par,
				c: '#8bc34a'
			});
		},
		err: function( par ) {
			if ( this.toast === null ) {
				this.toast = []
			}
			this.toast.push({
				l: par,
				c: '#f16363'
			});
		}
	}
})

statusMode = true;
var firstFiveCards = [];

function updateVideos () {
	$.ajax({
		type: "POST",
		url: "project/getVideos",
		data: {id: id_project},
		success: function(data) {
			data = JSON.parse(data);
			videoLists.videos = (data.length > 0) ? data : null;
		}
	});
}

function updateImages () {
	$.ajax({
		type: "POST",
		url: "project/getGallery",
		data: {id: id_project},
		success: function(data) {
			data = JSON.parse(data);
			imageLists.images = (data.length > 0) ? data : null;
		}
	});
}

function bindAll() {

	setTimeout(function(){
		$('.p-more').unbind('click');
		$('.p-more').bind('click', function() {
			$(this).siblings('.options').css('transform', 'translateY(0px)');
		});

		$('.cancel').click(function() {
			$(this).parent().css('transform', 'translateY(170px)');
		});

		$(".edit").click(function() {
			statusMode = "project/update";
			var settings = $(this).parent().parent().siblings("md-settings");

			$("#id_project_videos").val(settings.children("[p_id]").text());
			$("#id_project_images").val(settings.children("[p_id]").text());

			$("#key_project_videos").val(settings.children("[p_key]").text());
			$("#key_project_images").val(settings.children("[p_key]").text());
			id_project = settings.children("[p_id]").text();
			videoLists.projectKey = settings.children("[p_key]").text();
			imageLists.projectKey = settings.children("[p_key]").text();

			updateVideos();
			updateImages();

			customFields.loadCurrentFields();
			customFields.loadMissingFields();

			$("[name='description_es']").val(settings.children("[p_description_es]").text());
			$("[name='description_en']").val(settings.children("[p_description_en]").text());
			$("[name='key']").val(settings.children("[p_key]").text());
			$("[name='id']").val(settings.children("[p_id]").text());
			$("[name='price']").val(settings.children("[p_price]").text());
			$("[name='property_type'] option[value='"+settings.children("[p_property_type]").text()+"']").prop("selected", true);
			$("[name='service_type'] option[value='"+settings.children("[p_service_type]").text()+"']").prop("selected", true);
			$("[name='zone'] option[value='"+settings.children("[p_zone]").text()+"']").prop("selected", true);
			$("[name='name']").val(settings.children("[p_name]").text());
			$("[name='status']").val(settings.children("[p_status]").text());
			$("[name='photo_path']").val(settings.children("[p_photo_path]").text());

			$('[name=photo]').attr('type', 'hidden');
			$('[for=photo]').hide();
			$('[name=photo]').val(settings.children("[p_photo_path]").text())

			$("[name='photo_status']").val("same");

			if(settings.children("[p_photo_path]").text() == "") {
				$('#thumbnail').attr('style', 'background-image: url(images/default.png)');
			}else{
				$('#thumbnail').attr('style', 'background-image: url(' +settings.children("[p_photo]").text() + ')');
			}

			$('#thumbnail').css({
				'background-size': 'cover',
				'background-size': 'center',
				'padding-top': '40%'
			});

			$(".md-modal").show();
			$('#mdrawer_trgger').hide();
			$("#addProjectForm").show();
			$("[trigger]").show();
			$('.cancel').click();
		});

		var el = document.getElementById('projects');

		var sortable = Sortable.create(el, {
			handle: ".move-project",
			animation: 300,
			onEnd: function ( evt ) { manageFirsts()
			}
		});

	},100);
}

$('#addImage').click(function() {
	if ($(this).text() === 'cancelar') {
		$(this).text('nuevo');
		$('#imageLists').show();
		$('#my-awesome-dropzone-gallery').hide();
		$('#uploadImages').css('display', 'none');
	} else {
		$('#uploadImages').css('display', 'flex');
		$(this).text('cancelar');
		$('#imageLists').hide();
		$('#my-awesome-dropzone-gallery').show();
	}
});

$('#addVideo').click(function() {
	if ($(this).text() === 'cancelar') {
		$(this).text('nuevo');
		$('#videoLists').show();
		$('#my-awesome-dropzone-videos').hide();
		$('#uploadVideos').css('display', 'none');
	} else {
		$(this).text('cancelar');
		$('#uploadVideos').css('display', 'flex');
		$('#videoLists').hide();
		$('#my-awesome-dropzone-videos').show();
	}
});


$("#newProject").click(function() {
	statusMode = "project/save";
	$(".md-modal").show();
	$("#addProjectForm").show();
	$('#mdrawer_trgger').hide();
	$("#initProject")[0].reset();
	$("#erasePhoto").click();
	$('[trigger=t4]').hide();
	$('[trigger=t3]').hide();
	$('[trigger=t2]').hide();
	$('[trigger=t1]').click();
	$("[name='photo_status']").val(0);
});

$('.md-modal').click(function() {
	$('#mdrawer_trgger').show();
	$('.md-modal').hide();
	$('#addProjectForm').hide();
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
						if(!data.error) {
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

var fields = new Vue ({
	el: '#initProject',
	data: {
		properties: null,
		zones: null,
		services: null
	}
})

$.ajax({
	type: 'POST',
	url: 'zone/get',
	success: function( res ) {
		res = JSON.parse(res)
		fields.zones = (res.length > 0) ? res : null;
	}
});

$.ajax({
	type: 'POST',
	url: 'service/get',
	success: function( res ) {
		res = JSON.parse(res);
		fields.services = (res.length > 0) ? res : null;
	}
});

$.ajax({
	type: 'POST',
	url: 'property/get',
	success: function( res ) {
		res = JSON.parse(res);
		fields.properties = (res.length > 0) ? res : null;
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
	$('[name=photo]').val(null);
	$('[name=photo]').attr('type', 'file');
	$('[for=photo]').show();
	$("[name='photo_status']").val(0);
});

$("#initProject").submit(function(e) {
	console.log(statusMode);
	$('#loadingScreen').css('display', 'flex');
	e.preventDefault();
	$.ajax({
		type: "POST",
		url: statusMode,
		data: new FormData(this),
		processData: false,
		contentType: false,
		success: function(data) {
			$('#loadingScreen').css('display', 'none');
			var response = JSON.parse(data);
			response.key = response.directory;
			response.photo = response.photoGenerate;

			if ( statusMode === 'project/save' ) {
				if ( response.error ) {
					for(err in response.error) {
						if (err === 'name') { toasts.err('Campo título vacío') }
						if (err === 'description_en') { toasts.err('Descripción (ingles) vacía') }
						if (err === 'description_es') { toasts.err('Descripción (español) vacía') }
						if (err === 'zone') { toasts.err('Seleccione una zona') }
						if (err === 'price') { toasts.err('Es necesario agregar un precio') }
						if (err === 'service_type') { toasts.err('Seleccione un tipo servicio') }
						if (err === 'property_type') { toasts.err('Seleccione una ') }
					}
				} else {
					if(!proj.projects) {
						proj.projects = [];
					}
					proj.projects.push(response);
					bindAll();
					console.log(response);
					id_project = response.id;

					customFields.loadCurrentFields();
					customFields.loadMissingFields();

					statusMode = 'project/update';
					videoLists.projectKey = response.key
					imageLists.projectKey = response.key

					$("#id_project_videos").val(response.id);
					$("#id_project_images").val(response.id);

					$("#key_project_videos").val(response.key);
					$("#key_project_images").val(response.key);

					proj.globalIndex = parseInt(proj.projects.length - 1);
					console.log(proj.projects.length - 1);



					$('[trigger]').show();

					$("[name='key']").val(response.key);
					$("[name='id']").val(response.id);

					toasts.ok('Proyecto guardado con éxito!');
				}
			} else {
				if ( response.error ) {

					$(`[name=name]`).css('border', '2px solid gray');
					$(`[name=description_en]`).css('border', '2px solid gray');
					$(`[name=description_es]`).css('border', '2px solid gray');

					for(err in response.error) {
						if (err === 'name') { toasts.err('Campo título vacío') }
						if (err === 'description_en') { toasts.err('Descripción (ingles) vacía') }
						if (err === 'description_es') { toasts.err('Descripción (español) vacía') }
						if (err === 'price') { toasts.err('Hace falta un precio') }
					}
				} else {

					var _currentId = $('#initProject').find('[name=id]').val();
					var currentIndxElement;

					proj.projects[proj.globalIndex].description_en = response.description_en;
					proj.projects[proj.globalIndex].description_es = response.description_es;
					proj.projects[proj.globalIndex].name = response.name;

					proj.projects[proj.globalIndex].notPhoto = response.notPhoto;
					proj.projects[proj.globalIndex].photo = response.photo;
					proj.projects[proj.globalIndex].property_type = response.property_type;
					proj.projects[proj.globalIndex].service_type = response.service_type;
					proj.projects[proj.globalIndex].status = response.status;
					proj.projects[proj.globalIndex].zone = response.zone;
					proj.projects[proj.globalIndex].price = response.price;

					toasts.ok('Proyecto guardado con éxito!');

					/*
					$(".md-modal").hide();
					$("#addProjectForm").hide();
					*/
				}
			}
		}
	});
});

function manageFirsts() {
	firstFiveCards = [];
	$.each($('.card'), function( el, indx ) {
		firstFiveCards.push( $(indx).find('[data-id]').attr('data-id') )
	});
} manageFirsts();

$(document).ready(function() {

	$.ajax({
		type: "POST",
		url: "project/get",
		success: function(data) {

			bindAll();

			var response = JSON.parse(data);
			if(response.length > 0) {
				proj.projects = response;
			}
			$('#loadingScreen').hide();
		}
	});

	$('#tabHeaders span').click(function() {
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		var tab = $(this).attr('trigger');
		$('.tab').hide();
		$(`.${tab}`).css('display', 'block');
	});

	$('#cancel').click(function() {

		$('.md-modal').hide();
		$('#addProjectForm').hide();
		$('#mdrawer_trgger').show();
	});

});

Dropzone.options.myAwesomeDropzoneGallery = {
	autoProcessQueue: false,
	uploadMultiple: true,
	maxFiles: 15,
	maxFilesize: 50,
	addRemoveLinks: false,
	parallelUploads: 100,
	timeout: 180000000,
	dictResponseError: 'Server not Configured',
	acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
	init:function(){
		var self = this;

		$("#uploadImages").on("click", function() {
			self.processQueue(); // Tell Dropzone to process all queued files.
		});
		// config
		self.options.addRemoveLinks = true;
		self.options.dictRemoveFile = "Eliminar";
		var counter_files = self.files.length;

		self.on("queuecomplete", function (progress) {
			$('.meter').delay(999).slideUp(999);


			self.removeAllFiles(true);
			toasts.ok('Se subió todo correctamente');
			$('#addImage').click();
			updateImages();
		});

	}
};

Dropzone.options.myAwesomeDropzoneVideos = {
	autoProcessQueue: false,
	uploadMultiple: true,
	maxFiles: 1,
	maxFilesize: 150,
	addRemoveLinks: false,
	parallelUploads: 100,
	timeout: 180000000,
	dictResponseError: 'Server not Configured',
	acceptedFiles: ".mov,.mp4,.mpeg,.avi",
	init:function(){
		var self = this;

		$("#uploadVideos").on("click", function() {
			self.processQueue(); // Tell Dropzone to process all queued files.
		});
		// config
		self.options.addRemoveLinks = true;
		self.options.dictRemoveFile = "Delete";
		var counter_files = self.files.length;

		self.on("queuecomplete", function (progress) {
			$('.meter').delay(999).slideUp(999);


			self.removeAllFiles(true);

			$('#addVideo').click();
			toasts.ok('Se subió todo correctamente');
			updateVideos();
		});
	}
};

var videoLists = new Vue({
	el: '#videoLists',
	data: {
		videos: null
	},
	methods: {
		deleteVideo: function(_id, index) {
			if (confirm('Desea borrar el video?')) {

				$.ajax({
					type: 'POST',
					url: 'project/deleteVideo',
					data: ({id: _id}),
					success: function(data) {
						data = JSON.parse(data);

						if ( !data.error ) {
							toasts.ok('Video borrado');
							videoLists.videos.splice(index, 1);
						} else {
							toasts.err('No se pudieron recuperar los videos');
						}
					}
				});
			}
		}
	}
});

var imageLists = new Vue({
	el: '#imageLists',
	data: {
		images: null
	},
	methods: {
		deleteImage: function(_id, index) {
			if (confirm('Desea borrar la imagen?')) {

				$.ajax({
					type: 'POST',
					url: 'project/deleteImage',
					data: ({id: _id}),
					success: function(data) {
						data = JSON.parse(data);

						if ( !data.error ) {
							toasts.ok('Imagen borrada');
							imageLists.images.splice(index, 1);
						} else {
							toasts.err('No se pudieron recuperar las imágenes');
						}
					}
				});
			}
		}
	}
});


</script>
