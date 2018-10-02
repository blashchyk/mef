(function( $ ) {

	//Variables, on page load
	var $m_carousel = $('#bootstrap-carousel-animated'),
		$first_slide_animating_elements = $m_carousel.find('.item:first').find("[data-animation ^= 'animated']");

	//Initialize Carousel
	$m_carousel.carousel();
	
	//Animate captions in first slide on page load 
	do_caption_animations($first_slide_animating_elements);
	
	//Pause carousel  
	$m_carousel.carousel('pause');
	
	//Other slides to be animated on carousel slide event 
	$m_carousel.on('slide.bs.carousel', function (e) {
        var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
		do_caption_animations($animatingElems);
	});  

    /** Function to animate slider captions  **/
	function do_caption_animations( elems ) {
		//Cache the animationend event in a variable
		var animEndEv = 'webkitAnimationEnd animationend';
		elems.each(function () {
            var $this = $(this),
                $animationType = $this.data('animation');
			$this.addClass($animationType).one(animEndEv, function () {
                $this.removeClass($animationType);
			});
		});
	}
	
})(jQuery);
