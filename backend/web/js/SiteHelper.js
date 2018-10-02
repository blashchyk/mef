'use strict';

var SiteHelper = {
    map: {},

    _map: function() {
        var $this = this;
        $this.map = {
            expandLink: $('a.expand'),
            actionLink: $('a.action-link'),
            actionAllLink: $('a.action-list-link'),
            pageSize: $('select#page-size'),
            gridElement: $('.grid-view'),
            gridSortable: $('.grid.sortable'),
            form: $('form'),
            navTabs: $('ul.nav-tabs'),
            recordName: $('input.record-name'),
            recordSlug: $('input.record-slug'),
            userBirthday: $('input#user-birthday'),
            datePicker: $('input#date-picker'),
            activeTab: 'form .tab-pane:has(".has-error")',
            expandCell: '.kv-expand-icon-cell',
            checkedIds: 'input[name="selection[]"]:checked',
            clipboardButton: '.btn-clipboard',
        };
    },

    init: function() {
        var $this = this;
        $this._map();
        $this.map.expandLink.click(function() { return $this.expandLinkClick(this); });
        $this.map.actionLink.click(function() { return $this.actionLinkClick(this); });
        $this.map.actionAllLink.click(function() { return $this.actionAllLinkClick(this); });
        $this.map.pageSize.change(function() { return $this.pageSizeChange(this); });
        $this.map.recordName.change(function() { return $this.recordNameChange(this); });
        $this.map.datePicker.change(function() { return $this.datePickerChange(this); });
        $this.tabContentLoad();
        $this.map.form.on('afterValidate', function () { $this.tabContentLoad();});
        new Clipboard($this.map.clipboardButton);

    },

    expandLinkClick: function(link) {
        var $this = this;

        $(link).parents('tr').find($this.map.expandCell).click();

        return false;
    },

    actionLinkClick: function(link) {
        var $this = this,
            href = $(link).attr('href'),
            parent = $(link).parent(),
            message = $(link).data('confirm');

        if (message != undefined && message != '' && !confirm(message)) {
            return false;
        }

        parent.addClass('hidden');

        $.ajax({
            url: href,
            type: 'GET',
            success: function (response) {}
        });

        return false;
    },

    actionAllLinkClick: function(link) {
        var $this = this,
            href = $(link).attr('href'),
            message = $(link).data('confirm'),
            ids = [];

        if ($this.map.gridElement.length > 0) {
            ids = $this.map.gridElement.yiiGridView('getSelectedRows');
        } else {
            $this.map.gridSortable.find($this.map.checkedIds).each(function () {
                ids.push($(this).val());
            });
        }

        if (message != undefined && message != '' && !confirm(message)) {
            return false;
        }

        $.ajax({
            url: href,
            type: 'POST',
            data: {ids: ids},
            success: function (response) {
                if (response.success == true) {
                    window.location = window.location;
                }
            }
        });

        return false;
    },

    pageSizeChange: function(element) {
        var $this = this,
            form = $(element).parents('form');
        
        form.submit();

        return false;
    },

    recordNameChange: function(element){
        var $this = this,
            name = $(element).val(),
            slug = name.toLowerCase().replace(/ /g, '-');

        if ($this.map.recordSlug.val() == '') {
            $this.map.recordSlug.val(slug);
        }

        return true;
    },

    datePickerChange: function(element){
        var $this = this;

        $this.map.userBirthday.change();

        return true;
    },

    tabContentLoad: function() {
        var $this = this,
            tabName = $($this.map.activeTab).prop('id'),
            activeTab = $this.map.navTabs.find('a[href="#' + tabName + '"]');

        if (activeTab.length == 1) {
            activeTab.tab('show');
        }
    },

};

$(function() {
    SiteHelper.init();
});

