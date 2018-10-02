var NestedHelper = {

    map: {},

    _mapBase: function () {
        var $this = this;
        $this.map = {
            sortable: $('ol.nested-sortable'),
            empty: $('div.nested-empty'),
            disclose: 'p.disclose',
            detail: 'a.detail-button',
            delete: 'a.delete-button',
            collapsedClass: 'mjs-nestedSortable-collapsed',
            expandedClass: 'mjs-nestedSortable-expanded',
            containerClass: '.item-container',
            nameClass: '.item-name',
            typeClass: '.item-type',
            detailContainer: '.detail-container',
            detailDownClass: '.glyphicon-menu-down',
            detailUpClass: '.glyphicon-menu-up'
        };
    },

    initBase: function () {
        var $this = this;
        $this._mapBase();

        $this.initNestedPlugin();

        $this.map.sortable.delegate($this.map.disclose, 'click', function() { return $this.discloseClick(this); });
        $this.map.sortable.delegate($this.map.detail, 'click', function() { return $this.detailClick(this); });
        $this.map.sortable.delegate($this.map.delete, 'click', function() { return $this.deleteClick(this); });
    },

    initNestedPlugin: function () {
        var $this = this;
        $this.map.sortable.nestedSortable({
            forcePlaceholderSize: true,
            isTree: true,
            startCollapsed: false,
            handle: 'div',
            helper:	'clone',
            items: 'li',
            placeholder: 'placeholder',
            tolerance: 'pointer',
            toleranceElement: '> div',
            opacity: .7,
            revert: 250,
            tabSize: 35,
            //maxLevels: 6,
            expandOnHover: 700
            //change: function() { },
            //sort: function() { },
            //relocate: function() { },
            //update: function() { }
        });
    },

    discloseClick: function(element) {
        var $this = this;
        
        $(element).closest('li').toggleClass($this.map.collapsedClass).toggleClass($this.map.expandedClass);
        
        return true;
    },

    detailClick: function(element) {
        var $this = this;

        $(element).closest($this.map.containerClass).find($this.map.detailContainer).toggle(200);
        $(element).find('span').toggleClass($this.map.detailDownClass.substring(1)).toggleClass($this.map.detailUpClass.substring(1));
        
        return false;
    },

    deleteClick: function(element) {
        var $this = this,
            message = $(element).data('confirm');
        
        if (message == undefined || message == '' || confirm(message)) {
            $(element).closest('li').remove();

            if ($this.map.sortable.find('li').length == 0) {
                $this.map.empty.removeClass('hidden');
            }
        }

        return false;
    }
}

$.ui.isOverAxis = function(a, b, d){return a > b && a < b + d}