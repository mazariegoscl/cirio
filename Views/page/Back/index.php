<main>
	<div id="background"></div>
	<div class="slogan">
		<h2><?=SLOGAN?></h2>
	</div>

	<section class="projects" id="projects">

		<div class="index-message">
			<h3><?=H_OPTION?></h3>
			<hr>
			<p><?=H_OPTION_LABEL?></p>
		</div>
		<div id="cards" class="cards">
			<ul>
				<li v-for='pro in dataProjects' v-if="pro.status === 'active'">
					<a :href="'<?=$_SESSION['lang']?>/project/' + pro.url">
						<figure  :style='"background-image: url(" + "images/projects/" + pro.key + "/" + pro.photo +"), url(images/default.png), -webkit-linear-gradient(top, black, white); background-position: center; background-size: cover;"'>
							<p style="color: white;">{{pro.name}}</p>
						</figure>
					</a>
				</li>
			</ul>
			<a class="projects-anchor" href="<?=$_SESSION['lang']?>/estates">
				<?=H_MORE_PROJECTS?>
			</a>
		</div>
		<div class="keys-bg" style="background-image: -webkit-linear-gradient(30deg, #5f5f5f4f, #02020287), url(assets/img/services3.jpg);padding-top: 144px;">
			<p style="color: white;text-align: center;font-size: 26px;margin-bottom: 13px;font-weight: bold;">Riviera Maya</p>
			<h3 style="padding: 15px;border: 2px solid white;width: 340px;text-align: center;font-size: 32px;"><?=SOON?></h3>
		</div>
		<div class="contact">
			<h3><?=FORM_C?></h3>
			<form id="contactForm">
				<div>
					<label><?=FORM_NAME?></label>
					<input type="text" name="name">
				</div>
				<div>
					<label for=""><?=FORM_LAST_NAME?></label>
					<input type="text" name="las_name">
				</div>
				<div>
					<label><?=FORM_PHONE?></label>
					<input type="text" name="phone" maxlength="10">
				</div>
				<div>
					<label><?=FORM_MAIL?></label>
					<input type="text" name="mail">
				</div>
				<label><?=FORM_MSSAG?></label>
				<textarea name="message" maxlength="140"></textarea>
			</form>
		</div>
	</section>
	<div class="wecomeScreen">
		<div class="logoOnWelcome">
			<img src="./assets/img/logo.svg">
		</div>
	</div>
</main>
<!--<script type="text/javascript" src="assets/js/home.js"></script>-->
<script>
var projects = new Vue({
	el:'#cards',
	data: {
		dataProjects : null
	}
});

$(document).ready(function() {
	$.ajax({
		type: "POST",
		url: "<?=$_SESSION['lang']?>/projects",
		data: {lang: '<?=$_SESSION["lang"]?>'},
		success: function(data) {
			var response = JSON.parse(data);
			projects.dataProjects = response;
			console.log(response);
		}
	});

	var $slogan = $('.slogan h2');
	var $background = $('#background');
	var $bestOptionText = $('.best-option p');
	var $bestOptionImg = $('.best-option img');
	var $menu = $('#menu');
	var $body = $('body');
	var $nav = $('nav ul');
	var $boxes = $('.boxes');

	$(window).on('scroll', function(ev) {
		$slogan.css({
			'transform': `translateY(${-$(window).scrollTop() * 0.5}px)`,
			'line-height': `${2.2 - $(window).scrollTop() * 0.005}em`
		});
		console.log()
		$background.css('transform', `translateY(${-$(window).scrollTop() * 0.3}px)`);
		$bestOptionText.css('line-height', ($(window).scrollTop() * 0.07) + 'px');
		$bestOptionImg.css('transform', `translateY(${-$(window).scrollTop() * 0.3 + 300}px)`);
		$boxes.css('transform', `translateY(${-$(window).scrollTop() * 0.2 + 300}px)`)
	});
});

</script>
