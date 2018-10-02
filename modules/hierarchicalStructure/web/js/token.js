jQuery(document).ready(function ($) {

    function showAlertMessage(alertClass, alertMessage) {
        $(alertClass).css({'display' : 'block', 'opacity' : 1});
        $(alertClass).fadeTo(5000, 0).slideUp(500, function(){
            $(this).hide();
        });
        if (alertMessage.length > 0)
        $(alertClass).append(alertMessage);
    }

    $('.js-reset-token-button').on('click', function () {
        $.ajax({
            url: '/admin/hierarchicalStructure/token/reset-token',
            type: 'POST'
        })
        .done(function(data) {
            console.log(data);
            if( data.status == 'success') {
                $('.js-api-access-token').html(data.newToken);
                showAlertMessage('.js-token-alert-success', data.message);
            } else if (data.status == 'error') {
                showAlertMessage('.js-token-alert-error', data.message);
            } else {
                showAlertMessage('.js-token-alert-unknown-error', data.message);
            }
        })
        .fail(function(xhr, textStatus, errorThrown) {
            console.log(xhr);
        });
        return false;
    });
});