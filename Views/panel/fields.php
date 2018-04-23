<!DOCTYPE html>
<html>
<head>
	<?php require_once('Views/panel/head.php'); ?>
</head>
<body>
	<aside>
		<?php require_once('Views/panel/aside.php') ?>
	</aside>
	<main>
		<section id="search">
			<i class="material-icons">search</i>
			<input autocomplete="off" type="text" name="search" placeholder="buscar...">
		</section>

		<div id="fields">

			<ul class="zone">
				<li><b>ZONAS</b></li>
				<li v-for="(z, index) in zone">
					<span @click="updateZone(z, index)" :data-id="z.id" :dt-status="z.status">{{ z.name }}</span>
					<i @click="deleteZone(z.id, index)" class="material-icons delete-field" :dt-status="z.status">close</i>
				</li>
				<li><span @click="saveZone()">Agregar otro</span></li>
			</ul>



			<ul class="service_type">
				<li><b>SERVICIOS</b></li>
				<li v-for="(s, index) in service_type">
					<span @click="updateField('service/update', s, index)" :dt-status="s.status" :data-id="s.id">
						<en>{{ s.name_es }}</en> / <es>{{ s.name_en }}</es>
					</span>
					<i :dt-status="s.status" @click="deleteService(s.id, index)" class="material-icons delete-field">close</i>
				</li>
				<li><span @click="saveField('service/save')">Agregar otro</span></li>
			</ul>


			<ul class="property_type">
				<li><b>TPOS DE PROPIEDADES</b></li>
				<li v-for="(p, index) in property_type">
					<span @click="updateField('property/update', p, index)" :dt-status="p.status" :data-id="p.id">
						<en>{{ p.name_es }}</en> / <es>{{ p.name_en }}</es>
					</span>
					<i :dt-status="p.status" @click="deleteProperty(p.id, index)" class="material-icons delete-field">close</i>
				</li>
				<li><span @click="saveField('property/save')">Agregar otro</span></li>
			</ul>








			<!-- crud files -->
			<form class="zone-flieds">
				<input type="hidden" name="id" id="zoneId">
				<label for="field">nombre</label>
				<input autocomplete="off" type="text" name="name" id="field">
				<label for="status">estatus:</label>
				<select name="status" id="zoneStatus">
					<option value="active">Activo</option>
					<option value="inactive">Inactivo</option>
				</select>
				<br>
				<input autocomplete="off" type="submit" name="send" value="GUARDAR">
			</form>
			<!-- crud files -->



			<form class="other-flieds">
				<input type="hidden" name="id" id="otherId">
				<label for="field">nombre (español):</label>
				<input autocomplete="off" type="text" name="name_es">
				<label for="field">nombre (ingles):</label>
				<input autocomplete="off" type="text" name="name_en">
				<label for="status">estatus:</label>
				<select name="status" id="fieldsId">
					<option value="active">Activo</option>
					<option value="inactive">Inactivo</option>
				</select>
				<br>
				<input autocomplete="off" type="submit" name="send" value="GUARDAR">
			</form>

		</div>
		<span class="md-modal"></span>
		<div id="toasts">
			<span v-for="t in toast">{{ t.l }}</span>
		</div>
	</main>
</body>
</html>
<script>

var toasts = new Vue ({
	el: '#toasts',
	data: {
		toast: null
	},
	methods: {
		disp: function( par ) {
			if ( this.toast === null ) {
				this.toast = []
			}
			this.toast.push({ l: par });
		}
	}
})

var fields = new Vue({
	el: '#fields',
	data: {
		zone: null,
		service_type: null,
		property_type: null
	},
	methods: {
		deleteZone: function( _id, index ) {
			if( confirm('¿Seguro que desea borrar?') ) {

				$.ajax({
					url: 'zone/delete',
					type: 'POST',
					data: {id: _id},
					success: function(res) {
						res = JSON.parse(res);
						if ( !res.error ) {
							fields.zone.splice(index, 1);
						}
					}
				});
			}
		},
		deleteService: function( _id, index ) {
			if( confirm('¿Seguro que desea borrar?') ) {
				$.ajax({
					url: 'service/delete',
					type: 'POST',
					data: {id: _id},
					success: function(res) {
						res = JSON.parse(res);
						if ( res.error ) {
						} else {
							fields.service_type.splice(index, 1);
						}
					}
				});
			}
		},
		deleteProperty: function( _id, index ) {
			if( confirm('¿Seguro que desea borrar?') ) {
				$.ajax({
					url: 'property/delete',
					type: 'POST',
					data: {id: _id},
					success: function(res) {
						res = JSON.parse(res);
						if ( res.error ) {
						} else {
							fields.property_type.splice(index, 1);
						}
					}
				});
			}
		},
		saveZone: function() {
			this.globalContext = 'save'
			$('.zone-flieds').show();
			$('.zone-flieds').find('[name=name]').focus();
			$('.zone-flieds')[0].reset();
			$('.md-modal').show();
		},
		saveField: function( context ) {
			this.globalContext = context
			$('.other-flieds').show();
			$('.other-flieds').find('[name=name_es]').focus();
			$('.other-flieds')[0].reset();
			$('.md-modal').show();
		},
		updateZone: function(ob, index) {
			this.globalContext = 'update'
			this.globalIndex = index;
			$('.zone-flieds').show();
			$('.zone-flieds').find('[name=name]').val(ob.name);
			$('.zone-flieds').find('#zoneId').val(ob.id);
			$('#zoneStatus option[value="' + ob.status + '"]').prop("selected", true);
			$('.md-modal').show();
		},
		updateField: function(context, ob, index) {
			console.log(ob);
			this.globalContext = context
			this.globalIndex = index;
			$('.other-flieds').show();
			$('.other-flieds').find('[name=name_es]').val(ob.name_es);
			$('.other-flieds').find('[name=name_en]').val(ob.name_en);
			$('.other-flieds').find('#otherId').val(ob.id);
			$('#fieldsId option[value="' + ob.status + '"]').prop("selected", true);
			$('.md-modal').show();
		}
	}
});

//$("[name='property_type'] option[value=' + 1 + ']")

$(document).ready(function() {
	$('.md-modal').click(function() {
		$(this).hide();
		$('.zone-flieds').hide();
		$('.other-flieds').hide();
	});

	$.ajax({
		type: 'POST',
		url: 'zone/get',
		success: function( res ) {
			res = JSON.parse(res)
			if (!res.error) {
				fields.zone = (res.length > 0) ? res : null;
			}
		}
	});

	$.ajax({
		type: 'POST',
		url: 'service/get',
		success: function( res ) {
			res = JSON.parse(res);
			if (!res.error) {
				fields.service_type = (res.length > 0) ? res : null;
			}
		}
	});

	$.ajax({
		type: 'POST',
		url: 'property/get',
		success: function( res ) {
			res = JSON.parse(res);
			if (!res.error) {
				fields.property_type = (res.length > 0) ? res : null;
			}
		}
	});

	$('.other-flieds').submit(function(e) { e.preventDefault();
		$.ajax({
			type: 'POST',
			url: `${fields.globalContext}`,
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(res) {
				validate = JSON.parse(res);
				if (!validate.error) {

					console.log(validate)
					if (fields.globalContext === 'property/save') {
						if (fields.property_type === null) {
							fields.property_type = []
						}
						fields.property_type.push({
							id: validate,
							name_es: $('.other-flieds').find('[name=name_es]').val(),
							name_en: $('.other-flieds').find('[name=name_en]').val(),
							status: $('.other-flieds').find('[name=status]').val()
						});
					} else if (fields.globalContext === 'service/save') {
						if (fields.service_type === null) {
							fields.service_type = []
						}
						fields.service_type.push({
							id: validate,
							name_es: $('.other-flieds').find('[name=name_es]').val(),
							name_en: $('.other-flieds').find('[name=name_en]').val(),
							status: $('.other-flieds').find('[name=status]').val()
						});
					} else if (fields.globalContext === 'service/update') {

						fields.service_type[fields.globalIndex].name_es = $('.other-flieds').find('[name=name_es]').val();
						fields.service_type[fields.globalIndex].name_en = $('.other-flieds').find('[name=name_en]').val()
						fields.service_type[fields.globalIndex].status = $('.other-flieds').find('[name=status]').val();

					} else if (fields.globalContext === 'property/update') {

						fields.property_type[fields.globalIndex].name_es = $('.other-flieds').find('[name=name_es]').val();
						fields.property_type[fields.globalIndex].name_en = $('.other-flieds').find('[name=name_en]').val()
						fields.property_type[fields.globalIndex].status = $('.other-flieds').find('[name=status]').val();

					}
					$('.other-flieds').hide();
					$('.md-modal').hide();
				} else {
					console.log(validate);
					if ( validate.error.name_es ) { toasts.disp('Falta llenar el nombre (en español)'); }
					if ( validate.error.name_en ) { toasts.disp('Falta llenar el nombre (en ingles)'); }
				}
			}
		})
	});


	$('.zone-flieds').submit(function(e) { e.preventDefault();
		$.ajax({
			type: 'POST',
			url: `zone/${fields.globalContext}`,
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(res) {
				if (!res.error) {
					if (fields.zone === null) {
						fields.zone = []
					}

					if (fields.globalContext === 'save') {
						fields.zone.push({
							id: res,
							name: $('.zone-flieds').find('[name=name]').val(),
							status: $('.zone-flieds').find('[name=status]').val()
						});
					} else {
						console.log(fields.globalIndex);
						fields.zone[fields.globalIndex].name = $('.zone-flieds').find('[name=name]').val()
						fields.zone[fields.globalIndex].status = $('.zone-flieds').find('[name=status]').val()

						console.log({
							name: $('.zone-flieds').find('[name=name]').val(),
							status: $('.zone-flieds').find('[name=status]').val()
						});
					}
					$('.zone-flieds').hide();
					$('.md-modal').hide();
				} else {
					console.log('daisd ');
					toasts.disp('Falta agregar el nombre')
				}
			}
		})
	})

});

</script>
