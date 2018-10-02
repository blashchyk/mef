/*------------------------------------------------------------------
Project:    Oneline
Author:     Yevgeny S.
URL:        https://twitter.com/YevSim
Version:    1.0
Created:        28/04/2014
Last change:    22/07/2014
-------------------------------------------------------------------*/

/* ===== Feedback ===== */

$('.feedback-author').hover(function() {
    var quote = $(this).data('quote');
    $('.feedback-author').removeClass("active");
    $(this).addClass("active");
    $('.feedback-quote').removeClass("show animated fadeIn");
    $('.feedback-quote').addClass("hidden");
    $('.feedback-quote' + quote).toggleClass("hidden show");
    $('.feedback-quote' + quote).addClass("animated fadeIn");
    return false;
});