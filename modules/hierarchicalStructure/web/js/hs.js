jQuery(document).ready(function ($) {

    $('.eol .report').parent().parent().css('background-color', 'red');

    var loader = $('.js-export-loader');
    var downloadTimer;
    var attempts = 120;

    function getCookie( name ) {
        var parts = document.cookie.split(name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    }

    function expireCookie( cName ) {
        document.cookie = encodeURIComponent(cName) + "=; path=/; expires=" + new Date( 0 ).toUTCString();
    }

    function clearData(downloadToken) {
        window.clearInterval( downloadTimer );
        expireCookie(downloadToken);
        attempts = 120;
    }

    function showLoader(self, actionName, cookieName, isList, linkWrapClass, buttonClass) {
        var downloadToken = new Date().getTime();

        var hsId = self.data('id');

        if (isList) {
            self.hide();
            self.parent(linkWrapClass).children('.js-export-loader').css({'display': 'block'});
        } else {
            self.children('.js-export-button-text').hide();
            self.children('.js-export-loader').css({'display': 'block'});
            self.removeClass(buttonClass);
        }
        window.location = '/admin/hierarchicalStructure/default/' + actionName + '?hsId=' + hsId + '&tokenValue=' + downloadToken;

        downloadTimer = window.setInterval( function() {
            var token = getCookie(cookieName);

            if ((token == downloadToken) || (attempts == 0)) {
                clearData(cookieName);
                if (isList) {
                    self.parent(linkWrapClass).children('.js-export-loader').css({'display': 'none'});
                    self.show();
                } else {
                    self.children('.js-export-loader').css({'display': 'none'});
                    self.children('.js-export-button-text').show();
                    self.addClass(buttonClass);
                }
            }
            attempts--;
        }, 1000 );
    }

    /* HS list export links */

    $('.js-xml-link').on('click', function () {
        var self = $(this);
        showLoader(self, 'export-xml', 'downloadXml', true, '.js-xml-link-wrap');
        return false;
    });


    $('.js-pdf-link').on('click', function () {
        var self = $(this);
        showLoader(self, 'export-pdf', 'downloadPdf', true, '.js-pdf-link-wrap');
        return false;
    });

    $('.js-odt-link').on('click', function () {
        var self = $(this);
        showLoader(self, 'export-odt', 'downloadOdt', true, '.js-odt-link-wrap');
        return false;
    });

    /* Single hs export buttons */

    $('.js-export-pdf-button').on('click', function () {
        var self = $(this);
        showLoader(self, 'export-pdf', 'downloadPdf', false, '', '.js-export-pdf-button');
        return false;
    });

    $('.js-export-odt-button').on('click', function () {
        var self = $(this);
        showLoader(self, 'export-odt', 'downloadOdt', false, '', '.js-export-odt-button');
        return false;
    });

    $('.js-export-xml-button').on('click', function () {
        var self = $(this);
        showLoader(self, 'export-xml', 'downloadXml', false, '', '.js-export-xml-button');
        return false;
    });
    var click = 0;
    $('.btn-info').on('click', function () {
        click++;
        if (click > 1) {
            $("#funds-formhstree").parent().parent().clone(true).appendTo(".add_select");
        }
    })

    $('.button_select_update').on('click', function () {
        click++;
        $('.update_hidden').removeClass('hidden');
        if (click > 1) {
            $('#funds-hstree').parent().parent().clone(true).appendTo('.add_select');
        }
    })
    $('.btn-danger.button_select').on('click', function () {
        var selects = $('[id ^="funds-formhstree"]');
        if (selects.length > 2) {
            $(this).parent().parent().remove();
        } else {
            $(this).parent().parent().find('.text-danger').text('The HS field can not be deleted');
        }
    })
    $('.update').on('click', function () {
        if (click == 0) {
            $('.update_hidden').remove();
        }
    })
    $('.nav-tabs a').on('click', function () {
        var a = $(this).attr('href');
        $('button[name=active]').val(a);
    })
    var href = $('.nav-tabs li.active a').attr('href');
    $('button[name=active]').val(href);

    $('.kv-node-detail').on('dblclick', function () {
        $('.nav-tabs li[class!=active]').addClass('active');
        $('.nav-tabs li:first').removeClass('active');
        $('.tab-content div[class!=active]').addClass('active');
        $('.tab-content div:first').removeClass('active');
    })

    $('.kv-node-detail').on('click', function () {
        $('.nav-tabs li[class!=active]').addClass('active');
        $('.nav-tabs li:last').removeClass('active');
        $('.tab-content div[class!=active]').addClass('active');
        $('#w1-tab1').removeClass('active');
        $('#edit').removeClass('active');
    })
});


$(function () {

    $('.kv-node-detail').draggable({
        handle: ".kv-node-icon",
        zIndex: 5
    });
    var moveable,
        parent,
        x_down,
        x_up,
        y_down,
        y_up,
        root;

    $('.kv-parent').find('.kv-node-detail').on('mousedown', function (e) {
        $('.kv-node-detail').addClass('hover')
        moveable = $(this).parent().parent()
        x_down = e.pageX, y_down = e.pageY;
    })
    $('.kv-parent').find('.kv-node-detail').on('mouseup', function (e) {
        parent = $(this).parent().parent()
        x_up = e.pageX
        y_up = e.pageY
        if (x_down - x_up > 50 || y_down - y_up > 50 && parent == moveable) {
            root = true
        }

        if (moveable.attr('data-key') !== parent.attr('data-key') || root == true) {
            $.ajax({
                url: document.location.href,
                data: {
                    move_node_id  : moveable.attr('data-key'),
                    parent_id : parent.attr('data-key'),
                    root : root
                }
            }).done(function (success) {
                if (success) {
                    alert(success)
                }
                window.location.reload()
            })
        }
    })
})
$(document).ready(function() {
    var p = $(".left-block");
    var d = $(".right-block");
    var block = $('.central_section').width()

    var curr_width = p.width() / (p.width() + d.width())
    var unlock = false;

    $(document).mousemove(function(e) {
        var change = curr_width + (e.clientX - 530 - curr_width);
        if(unlock) {
            if(change > 199) {
                p.css("width", ((change + 250) / block * 100) + '%');
                $('.right-width').css("width", 100 - ((change + 250) / block * 100) + '%' );
            }
        }
    });

    d.mousedown(function(e) {
        curr_width = p.width();
        unlock = true;
    });

    $(document).mousedown(function(e) {
        if(unlock) {
            e.preventDefault();
        }
    });

    $(document).mouseup(function(e) {
        unlock = false;
    });

    $('#files-archive').change(function () {
        $('button.archiving_import').trigger('click');
    })
});