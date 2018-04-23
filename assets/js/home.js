

$(document).ready(function() {

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

	$menu.click(function() {
		if ( $(this).hasClass('show') ) {
			$(this).removeClass('show');
			$nav.removeClass('show');
			$slogan.css('opacity', '1');
			$body.css('overflow', 'auto');
		} else {
			$(this).addClass('show')
			$nav.addClass('show')
			$slogan.css('opacity', '0');
			$body.css('overflow', 'hidden');
		}
	});

});
