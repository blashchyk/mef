/*------------------------------------------------------------------
Project:    Oneline
Author:     Yevgeny S.
URL:        https://twitter.com/YevSim
Version:    1.0
Created:        28/04/2014
Last change:    22/07/2014
-------------------------------------------------------------------*/

// ========
// GENERAL 
// ========

/* ===== Navbar Search ===== */

$('#navbar-search > #open-search').on('click', function() {
    $(this).toggleClass('show hidden');
    $('#navbar-search > #close-search').toggleClass('show hidden');
    $("#navbar-search-box").toggleClass('show hidden animated fadeInDown');
    return false;
});
$('#navbar-search > #close-search').on('click', function() {
    $(this).toggleClass('show hidden');
    $('#navbar-search > #open-search').toggleClass('show hidden');;
    $("#navbar-search-box").toggleClass('fadeInDown fadeOutUp');
    setTimeout(function(){
        $("#navbar-search-box").toggleClass('show hidden animated fadeOutUp');
    }, 500);
    return false;
});

/* ====== Comments ===== */

$('.comment-textarea').on('focusin', function() {
    $(this).attr('rows', '3');
    $('.comment-send-btn').toggleClass('show hidden');
    $('.comment-form').toggleClass('focusin');
    return false;
});
$('.comment-textarea').on('focusout', function() {
    $(this).attr('rows', '2');
    $('.comment-send-btn').toggleClass('show hidden');
    $('.comment-form').toggleClass('focusin');
    return false;
});


/* ===== Thumbs rating ===== */

$('.rating .voteup').on('click', function () {
    var up = $(this).closest('div').find('.up');
    up.text(parseInt(up.text(),10) + 1);
    return false;
});
$('.rating .votedown').on('click', function () {
    var down = $(this).closest('div').find('.down');
    down.text(parseInt(down.text(),10) + 1);
    return false;
});


$('.gallery-link').magnificPopup({
    type: 'image',
    gallery:{enabled:true}
});
