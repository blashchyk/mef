'use strict';

jQuery(function($) {
    $('.permissions').click(function(){
        var permissions = $(this).closest('li').find('ul').find('.permissions');

        if($(this).is(':checked')){
            permissions
                .attr({'disabled':'disabled'})
                .prop('checked',true)
                .val(0);
        } else {
            permissions
                .prop('checked',false)
                .prop('disabled',false)
        }
    });
});