<i class="material-icons" id="mdrawer_trgger">menu</i>

<span class="__modal_drawer"></span>
<div id="drawer_js"></div>

<script type="text/javascript">
$(document).ready(function() {
	Drawer.init({
		main: {
			background: ' ',
			photo: ' ',
			title: 'Cabo BDS',
			subtitle: 'exam@mail.com'
		},
		menu: [{
			icon: 'dashboard',
			label: 'Proyectos',
			action: '<?=self::$base?>panel'
		},{
			icon: 'chrome_reader_mode',
			label: 'Campos estáticos',
			action: '<?=self::$base?>panel/fields'
		},{
			icon: 'settings',
			label: 'Ajustes',
			action: '<?=self::$base?>panel/settings'
		},{
			icon: 'list',
			label: 'Campos dinámicos',
			action: '<?=self::$base?>panel/customFields'
		},{
			icon: 'power_settings_new',
			label: 'Salir',
			action: '<?=self::$base?>panel/logout'
		}]
	});
});
</script>
