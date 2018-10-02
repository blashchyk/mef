$(document).ready(function(){
    $(window).resize(function(){
        var $wHieght = $(window).height(); $wHieght = $wHieght/2;
        //$('#video-image-carousel,#video-image-carousel .item').css('height',$wHieght+'px');
    });
    var $wHieght = $(window).height(); $wHieght = $wHieght/2;
    $('#video-image-carousel,#video-image-carousel .item').css('height',$wHieght+'px');
    $('#video-image-carousel .item .arrow').click(function(){
        var x = $($(this).attr('href')).offset().top-$('.navbar-magnet.navbar-fixed-top').height();
        $('html,body').animate({scrollTop:x},800);
        return false;
    });
    $('#video-image-carousel ul').bxSlider({nextText:'<i class="ic ic-angle-right-white"></i>',prevText:'<i class="ic ic-angle-left-white"></i>',speed:800,pause:8000,pager:false,controls:true,responsive:true,auto:true,mode:'fade',onSliderLoad:function(currentIndex){renderVideo();},onSlideAfter:function($slideElement, oldIndex, newIndex){renderVideo();}});
});
function renderVideo(){
	var isTouch = Modernizr.touch;
	if (!isTouch){
		var current = $('#video-image-carousel .item.active');
		if(current.attr('data-video')!='' && current.attr('data-video')){
			if(!current.hasClass('rendered')){
				var data_video = current.attr('data-video');
				BV = new $.BigVideo({container:current,useFlashForFirefox:false});
				BV.init();
				BV.show(data_video,{ambient:true});
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