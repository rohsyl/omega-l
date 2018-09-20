/*
	Snapshot by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
*/

(function($) {

	skel.breakpoints({
		xlarge: '(max-width: 1680px)',
		large: '(max-width: 1280px)',
		medium: '(max-width: 980px)',
		small: '(max-width: 736px)',
		xsmall: '(max-width: 480px)'
	});

	$(function() {

		var	$window = $(window),
			$body = $('body');

		// Disable animations/transitions until the page has loaded.
			$body.addClass('is-loading');

			$window.on('load', function() {
				window.setTimeout(function() {
					$body.removeClass('is-loading');
				}, 100);
			});

		// Fix: Placeholder polyfill.
			$('form').placeholder();

		// Prioritize "important" elements on medium.
			skel.on('+medium -medium', function() {
				$.prioritize(
					'.important\\28 medium\\29',
					skel.breakpoint('medium').active
				);
			});

		// Scrolly.
			$('.scrolly').scrolly();

		// Gallery.
			$('.gallery').each(function() {

				var	$gallery = $(this),
					$content = $gallery.find('.content');

				// Poptrox.
					$content.poptrox({
						usePopupCaption: true
					});

				// Tabs.
					$gallery.each( function() {

						var $this = $(this),
							$tabs = $this.find('.tabs a'),
							$media = $this.find('.media');

						$tabs.on('click', function(e) {

							var $this = $(this),
								tag = $this.data('tag');

							// Prevent default.
							 	e.preventDefault();

							// Remove active class from all tabs.
								$tabs.removeClass('active');

							// Reapply active class to current tab.
								$this.addClass('active');

							// Hide media that do not have the same class as the clicked tab.
								$media
									.fadeOut('fast')
									.each(function() {

										var $this = $(this);

										if ($this.hasClass(tag))
											$this
												.fadeOut('fast')
												.delay(200)
												.queue(function(next) {
													$this.fadeIn();
													next();
												});

									});

						});

					});


			});

	});

})(jQuery);


$(document).ready(function () {
  var trigger = $('.hamburger'),
      overlay = $('.overlay'),
     isClosed = false;

    trigger.click(function () {
      hamburger_cross();      
    });

    function hamburger_cross() {

      if (isClosed == true) {          
        overlay.hide();
        trigger.removeClass('is-open');
        trigger.addClass('is-closed');
        isClosed = false;
      } else {   
        overlay.show();
        trigger.removeClass('is-closed');
        trigger.addClass('is-open');
        isClosed = true;
      }
  }
  
  $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper').toggleClass('toggled');
  });  
});