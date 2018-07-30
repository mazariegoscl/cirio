<main>
	<div id="background"></div>
	<div class="slogan">
		<h2><?=ESTATES_MAIN_TITLE?></h2>
	</div>

	<section class="projects estates" style="background: transparent;" id="projects">
		<ul>
			<li v-for="p in projects">
				<div class="first">
					<figure width="400" height="400" :style="`background-image: url(images/projects/${p.key}/${p.photo}), url(images/default.png);`"></figure>
				</div>
				<div class="second">
					<h2>{{p.name}}</h2>
					<p>{{p.description_<?=$_SESSION['lang']?>}}</p>
					<a :href="'<?=$_SESSION['lang']?>/project/' + p.url"><?=VIEW_DETAILS?></a>
				</div>
			</li>
		</ul>
	</section>
</main>
<script type="text/javascript">

var rendererProjects = new Vue({
	el: '#projects',
	data: {
		projects: null
	}
});

$.ajax({
	url: '<?=$_SESSION['lang']?>/allprojects',
	type: 'POST',
	success: function(res) {
		res = JSON.parse(res);
		if (res.length > 0) {
			rendererProjects.projects = res;
			console.log(res);
		}
	}
});

</script>


<div id="cards" class="cards">
	<ul>
		<li v-for='pro in dataProjects'>
			<a :href="'<?=$_SESSION['lang']?>/project/' + pro.url">
				<figure  :style='"background-image: url(" + "images/projects/" + pro.key + "/" + pro.photo +");"'>
					<p>{{pro.name}}</p>
					<p><small>se more</small></p>
				</figure>
			</a>
		</li>
	</ul>
	<a class="projects-anchor" href="projects">
		<?=H_MORE?>
	</a>
</div>
<?= require_once("Views/page/footer.php"); ?>
