<!DOCTYPE html>
<html>
<head>
	<?php require_once('Views/panel/head.php'); ?>
	<title></title>
</head>
<body>
	<aside>
		<?php require_once('Views/panel/aside.php') ?>
	</aside>
	<main>
		<section id="customFields">
			<ul>
				<li v-for="(f, index) in fields">
					<span @click="updateField( 'field/update', f, index )" :status="f.status" :data-id="f.id"><b>es:</b> {{ f.name_es }} / <b>en:</b> {{ f.name_en }}</span>
				</li>
			</ul>
		</section>
		<div id="addCustomField">NUEVO CAMPO</div>
	</main>
	<form id="fieldsManager">
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
	<span class="md-modal"></span>
	<div id="toasts">
		<span v-for="t in toast">{{ t.l }}</span>
	</div>
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
});

var cFields = new Vue({
	el: '#customFields',
	data: {
		fields: null
	},
	methods: {
		updateField: function(context, ob, index) {
			this.globalContext = context;
			this.globalIndex = index;
			$('#fieldsManager').show();
			$('.md-modal').show();
			if (context === 'field/update') {
				$('#fieldsManager').find('[name=name_es]').val(ob.name_es);
				$('#fieldsManager').find('[name=name_en]').val(ob.name_en);
				$('#fieldsManager').find('[name=id]').val(ob.id);
				$('#fieldsId option[value="' + ob.status + '"]').prop("selected", true);
			}
			$('.md-modal').show();
			$('#fieldsManager').show();
		}
	}
});

$('#addCustomField').click(function() {
	// show form
	$('[name=name_es]').val('')
	$('[name=name_en]').val('')
	$('#fieldsId option[value="active"]').prop('selected', true);

	cFields.updateField('field/save', null, null);
});

$('#fieldsManager').submit(function(e) {
	e.preventDefault();
	$.ajax({
		type: 'POST',
		url: `${cFields.globalContext}`,
		data: new FormData(this),
		processData: false,
		contentType: false,
		success: function(res) {
			res = JSON.parse(res);
			console.log(res)
			if (cFields.globalContext === 'field/save') {
				if (!res.error) {
					if ( cFields.fields === null ) {
						cFields.fields = []
					}
					console.log(res);
					cFields.fields.push({
						name_en: $('#fieldsManager').find('[name=name_en]').val(),
						name_es: $('#fieldsManager').find('[name=name_es]').val(),
						id: res,
						status: $('#fieldsManager').find('[name=status]').val(),
					});
					$('#fieldsManager').hide();
					$('.md-modal').hide();
				} else {
					console.log(res);
					if ( res.error.name_es ) { toasts.disp('Falta llenar el nombre (en español)'); }
					if ( res.error.name_en ) { toasts.disp('Falta llenar el nombre (en ingles)'); }
				}

				/*CHECK FOR UPDATES*/

			} else if (cFields.globalContext === 'field/update') {
				if (!res.error) {
					if ( cFields.fields === null ) {
						cFields.fields = []
					}
					console.log(res);
					cFields.fields[cFields.globalIndex].name_en = $('#fieldsManager').find('[name=name_en]').val(),
					cFields.fields[cFields.globalIndex].name_es = $('#fieldsManager').find('[name=name_es]').val(),
					cFields.fields[cFields.globalIndex].status = $('#fieldsManager').find('[name=status]').val(),
					$('#fieldsManager').hide();
					$('.md-modal').hide();
				} else {
					console.log(res);
					if ( res.error.name_es ) { toasts.disp('Falta llenar el nombre (en español)'); }
					if ( res.error.name_en ) { toasts.disp('Falta llenar el nombre (en ingles)'); }
				}

			}
		}
	})
});

$(document).ready(function() {
	$('.md-modal').click(function() {
		$(this).hide();
		$('#fieldsManager').hide();
	})


	$.ajax({
		type: 'POST',
		url: 'field/get',
		success: function(res) {
			console.log(res);
			res = JSON.parse(res);
			if (!res.error) {
				cFields.fields = (res.length > 0) ? res : null;
			}
		}
	});

});
</script>
