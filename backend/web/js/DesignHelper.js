'use strict';

var DesignHelper = {
    map: {},

    _map: function() {
        var $this = this;
        $this.map = {
            toggleSideMenu: $('#toggle_sidemenu_l'),
            leftSideBar: $('#sidebar_left'),
            window: $(window),
            dropDownSideBar: $('#sidebar_left-collapse .dropdown-menu'),
            dropDownLiSideBar: $("#sidebar_left-collapse .dropdown"),
        };
    },

    init: function() {
        var $this = this;
        $this._map();
        $this.map.toggleSideMenu.click(function() { return $this.resizeSideMenu(); });
        $this.map.window.resize(function(){ return $this.windowResize(); });
        $this.map.dropDownSideBar.on('click', function(){return $this.dropDownShow(this)});
        $this.map.dropDownLiSideBar.on("show.bs.dropdown", function() { $this.sidebarWrapperSize(250)});
        $this.map.dropDownLiSideBar.on("hide.bs.dropdown", function() { $this.sidebarWrapperSize('')});
        $this.map.leftSideBar.scroll(function(){return $this.scrollBarPosition(this)});
    },

    dropDownShow: function(link) {
        if(!($('.sidebar-wrapper').hasClass('minimised'))) {
            $(link).addClass('show');
        } else {
            $(link).addClass('hide');
        }
    },

    scrollBarPosition: function (link) {
        var sidebarHeight=$('.sidebar-left-content.nano-content').height();
        var menuHeight=$('#sidebar_left-collapse').height();
        var div = (menuHeight + 40)/sidebarHeight;
        $('.scroll-body').css('height', div*100+'%');
        $('.scroll-body').css('top', 100*link.scrollTop/sidebarHeight+'%');
    },

    sidebarWrapperSize: function(size) {
        $('.sidebar-wrapper').css('width', size);
    },

    resizeSideMenu: function() {
        var size = $('#sidebar_left').width() ;
        if (this.getCookie('statusSideMenu')=='min') {
            this.showMenu(0);
        } else {
            this.hideMenu(0);
        }
    },

    windowResize: function () {
        if ($(window).width() <= '768'){
            return this.hideMenu(0);
        }
    },

    getCookie: function (name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    },

    hideMenu: function () {
        $('.sidebar-wrapper').addClass('minimised');
        $('.footer').addClass('minimised');
        $('#content_wrapper').addClass('minimised');
        $('.navbar-fixed-top').addClass('minimised');
        document.cookie = "statusSideMenu=min; path=/;";
    },

    showMenu: function() {
        $('.sidebar-wrapper').removeClass('minimised');
        $('.footer').removeClass('minimised');
        $('#content_wrapper').removeClass('minimised');
        $('.navbar-fixed-top').removeClass('minimised');
        document.cookie = "statusSideMenu=max; path=/;";
    }
};

$(function() {
    DesignHelper.init();
});

