jQuery(document).ready(function ($) {
    $('.js-start-import-analise').on('click', function () {
        $('.js-load-analise-import').show();
    });

    $('.js-collapse-import-info').on('click', function () {
        if (!$(this).hasClass('show-info')) {
            $(this).addClass('show-info');
            $('.js-plus').hide();
            $('.js-minus').show();
            $('.js-import-notice-area').show();
        } else {
            $(this).removeClass('show-info');
            $('.js-minus').hide();
            $('.js-plus').show();
            $('.js-import-notice-area').hide();
        }
    });
});