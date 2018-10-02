/*jquery-scrollstop*/
!function(factory){"function"==typeof define&&define.amd?define(["jquery"],factory):"object"==typeof exports?module.exports=factory(require("jquery")):factory(jQuery)}(function($){var dispatch=$.event.dispatch||$.event.handle,special=$.event.special,uid1="D"+ +new Date,uid2="D"+(+new Date+1);special.scrollstart={setup:function(data){var timer,_data=$.extend({latency:special.scrollstop.latency},data),handler=function(evt){var _self=this,_args=arguments;timer?clearTimeout(timer):(evt.type="scrollstart",dispatch.apply(_self,_args)),timer=setTimeout(function(){timer=null},_data.latency)};$(this).bind("scroll",handler).data(uid1,handler)},teardown:function(){$(this).unbind("scroll",$(this).data(uid1))}},special.scrollstop={latency:250,setup:function(data){var timer,_data=$.extend({latency:special.scrollstop.latency},data),handler=function(evt){var _self=this,_args=arguments;timer&&clearTimeout(timer),timer=setTimeout(function(){timer=null,evt.type="scrollstop",dispatch.apply(_self,_args)},_data.latency)};$(this).bind("scroll",handler).data(uid2,handler)},teardown:function(){$(this).unbind("scroll",$(this).data(uid2))}}});

$(document).ready(function() {

	//pause testimonial
	$('#testimonial-carousel').carousel({interval:0});
    
    //grid
    var $container = $('.magnet-iso-content');
	
    //search form
    $('.magnet-search .magnet-icon-search,.magnet-search .magnet-icon-search-close').click(function(e){
		e.stopPropagation();
		$(this).parent().toggleClass('open');
	});
	$('.magnet-search').click(function(e){
		e.stopPropagation();
	});
	$(document).click(function(e) {
		$('.magnet-search form').removeClass('open');
	});
    
    //grid
	initIsotope('.magnet-iso-content','.item','.magnet-iso-filter');
	initIsotope('.post-2-col','.post-grid',false);
	
    //back to top
    $(window).scroll(function(){
		if($(window).scrollTop()>100){
			if(!$('#back_to_top').hasClass('show'))
				$('#back_to_top').addClass('show');
			if(!$('#back_to_top').hasClass('scroll'))
				$('#back_to_top').addClass('scroll');
		}
		else
			$('#back_to_top').removeClass('show');
	});
	$(window).on('scrollstop',function(){
		$('#back_to_top').removeClass('scroll');
	});
	if($(window).scrollTop()>100) $('#back_to_top').addClass('show');
	else $('#back_to_top').removeClass('show');
	$('#back_to_top').click(function(){
		$('html,body').stop().animate({scrollTop:0},1000);
		return false;
	});

    //progress bars
	$('.progress').each(function(){
		var width = $(this).find('.progress-bar').attr('data-width');
		$(this).find('.progress-bar').css({'width':width});
	});

    //window resizing, full screen banners
	$(window).resize(function(){
		var $wHieght = $(window).height();
		var $nhHieght = $('.navbar-magnet').height();
		var $nnH = $wHieght-$nhHieght;
		$('.image-banner.full-screen').css('height',$nnH+'px');
	});
	var $wHieght = $(window).height();
	var $nhHieght = $('.navbar-magnet').height();
	var $nnH = $wHieght-$nhHieght;
	$('.image-banner.full-screen').css('height',$nnH+'px');
	if($('.image-banner.video').length>0) renderVideoBanner($('.image-banner.video'));
    
});

// init Isotope
function initIsotope(container,selector,filter){
	var $container = $(container),
		$selector = selector;
	$container.isotope({itemSelector: $selector});
	$container.imagesLoaded( function(){$container.isotope();});
	if(filter){
		// filter items on button click
		$(filter).on( 'click', 'a', function() {
			if($(this).hasClass('active')) return false;
			$(this).parent().parent().find('a').removeClass('active');
			$(this).addClass('active');
			var filterValue = $(this).attr('data-filter');
			$container.isotope({filter:filterValue});
			return false;
		});
	}
}


//video banner
var BV = false;
function renderVideoBanner(current){
	if(BV) BV.dispose();
    var isTouch = Modernizr.touch;
    //by default, videos do not auto play on mobile phones. so detect if device is a touch screen, if so, do not play video - instead show fallback image
    if (!isTouch){   
        if(current.attr('data-video')!='' && current.attr('data-video')){
            var data_video = current.attr('data-video');
            BV = new $.BigVideo({container:current,useFlashForFirefox:false});
            BV.init();
            BV.show(data_video, {ambient:true});
            var player = BV.getPlayer();
            $('#big-video-wrap',current).css('visibility','hidden');
            player.on('loadedmetadata', function(){
                $('#big-video-wrap',current).css('visibility','visible');
            });
        }else{
            BV = false;
        }
    }
}
