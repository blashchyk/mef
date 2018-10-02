$(document).ready(function(){
	$(window).resize(function(){
		var $wHieght = $(window).height();
		var $nhHieght = $('.navbar-magnet').height();
		var $nnH = $wHieght-$nhHieght;
		$('#video-image-carousel-full-screen,#video-image-carousel-full-screen .item').css('height',$nnH+'px');
	});
	$('#video-image-carousel-full-screen .item .arrow').click(function(){
		var x = $($(this).attr('href')).offset().top-$('.navbar-magnet.navbar-fixed-top').height();
		$('html,body').animate({scrollTop:x},800);
		return false;
	});
	$('#video-image-carousel-full-screen ul').bxSlider({nextText:'<i class="ic ic-angle-right-white"></i>',prevText:'<i class="ic ic-angle-left-white"></i>',speed:800,pause:8000,pager:false,controls:true,responsive:true,auto:true,mode:'fade',onSliderLoad:function(currentIndex){renderVideo();},onSlideAfter:function($slideElement, oldIndex, newIndex){renderVideo();}});
});
$(function(){
	var $wHieght = $(window).height();
	var $nhHieght = $('.navbar-magnet').height();
	var $nnH = $wHieght-$nhHieght;
	$('#video-image-carousel-full-screen,#video-image-carousel-full-screen .item').css('height',$nnH+'px');
});
var wH = window.innerHeight;
var mH = document.getElementById('navbar-main-magnet').innerHeight;
var nnH = wH-mH;
document.getElementById('video-image-carousel-full-screen').style.height=nnH+'px';
function renderVideo(){
	var isTouch = Modernizr.touch;
	if (!isTouch){
		var current = $('#video-image-carousel-full-screen .item.active');
		if(current.attr('data-video')!='' && current.attr('data-video')){
			if(!current.hasClass('rendered')){
				var data_video = current.attr('data-video');
				var BV = new $.BigVideo({container:current,useFlashForFirefox:false});
				BV.init();
				BV.show(data_video, {ambient:true});
				var player = BV.getPlayer();
				$('#big-video-wrap',current).css('display','none');
				player.on('loadedmetadata', function(){
					$('#big-video-wrap',current).fadeIn();
				});
				current.addClass('rendered');
			}
		}
	}
}