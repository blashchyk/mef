'use strict';

var MenuHelper = {

    map: {},

    TYPE_PAGE: 0,
    TYPE_LINK: 1,
    TYPE_TEXT: 2,

    newItemsAmount: 0,

    _construct: function () {
        if (typeof(NestedHelper) == "undefined") {
            return false;
        }

        var $this = this;
        $.extend($this, NestedHelper);
        $this.initBase();
    },

    _map: function () {
        var $this = this;
        $.extend($this.map, {
            sortable: $('ol.nested-sortable'),
            saveMenu: $('#save-menu'),
            itemTab: $('#menu-tabs li:eq(1) a'),
            itemList: $('input#TreeItems'),
            addItemModal: $('.modal#add-item-modal'),
            addPage: $('.add-page-button'),
            itemTemplate: $('.item-template'),
            addAllCheckbox: $('label :checkbox#pages-all'),
            pageList: $('.page-list'),
            pageCheckbox: $('.page-list :checkbox.page'),
            toggleDetail: $('.btn-group button.toggle-detail'),
            hideDetail: $('.btn-group a.hide-detail'),
            showDetail: $('.btn-group a.show-detail'),
            openAddPage: $('.btn-group a.open-add-page'),
            openAddLink: $('.btn-group a.open-add-link'),
            openAddText: $('.btn-group a.open-add-text'),
            addPageTab: $('#menu-item-tabs li:eq(0) a'),
            addLinkTab: $('#menu-item-tabs li:eq(1) a'),
            addTextTab: $('#menu-item-tabs li:eq(2) a'),
            inputContainer: 'div.form-group',
            successClass: '.has-success',
            addLinkForm: '#add-link-form',
            addTextForm: '#add-text-form',
            pageSelect: '#menuitem-0-page_id',
            linkNameInput: '#menuitem-0-link_name',
            urlInput: '#menuitem-0-url',
            typeInput: '#menuitem-0-type',
            inheritedSelect: '.inherited-select',
            linkNames: '.link-names',
        });
    },

    init: function () {
        var $this = this;

        $this._construct();
        $this._map();

        $this.map.saveMenu.click(function() { return $this.saveMenuClick(this); });
        $this.map.addPage.click(function() { return $this.addPageClick(this); });
        $this.map.addAllCheckbox.change(function() { return $this.addAllCheckboxСhange(this); });
        $this.map.pageCheckbox.change(function() { return $this.checkboxChange(this); });
        $this.map.openAddPage.click(function() { return $this.openAddItemTab($this.map.addPageTab); });
        $this.map.openAddLink.click(function() { return $this.openAddItemTab($this.map.addLinkTab); });
        $this.map.openAddText.click(function() { return $this.openAddItemTab($this.map.addTextTab); });
        $this.map.toggleDetail.click(function() { return $this.toggleDetailClick(this); });
        $this.map.hideDetail.click(function() { return $this.toggleDetailClick(this, false); });
        $this.map.showDetail.click(function() { return $this.toggleDetailClick(this, true); });
        $this.map.addItemModal.on("beforeSubmit", $this.map.addLinkForm, function () { return $this.addLinkFormSubmit(this); });
        $this.map.addItemModal.on("beforeSubmit", $this.map.addTextForm, function () { return $this.addTextFormSubmit(this); });
        $this.map.sortable.delegate($this.map.inheritedSelect, 'change', function() { return $this.inheritedSelectChange(this); });
    },

    saveMenuClick: function(element) {
        var $this = this,
            items = $this.map.sortable.nestedSortable('toArray', {startDepthCount: 1}),
            serializeItems = JSON.stringify(items);

        $this.map.itemList.val(serializeItems);

        return true;
    },

    addAllCheckboxСhange: function(element) {
        var $this = this,
            isChecked = $(element).prop('checked');

        $this.map.pageCheckbox.prop('checked', isChecked);
        $this.checkboxChange(element);

        return true;
    },

    checkboxChange: function(element) {
        var $this = this,
            addPageDisabled = $this.map.pageList.find(':checked').length == 0;

        $this.map.addPage.prop('disabled', addPageDisabled);

        return true;
    },

    addPageClick: function(element) {
        var $this = this;

        for (var i = 0; i < $this.map.pageCheckbox.length; i++) {
            var checkbox = $($this.map.pageCheckbox[i]);
            if (checkbox.prop('checked')) {
                var linkName = checkbox.parent('label').find('.link-name').text().trim(),
                    pageId = checkbox.val();
                $this.addMenuItem($this.TYPE_PAGE, linkName, pageId);
            }
        }

        $this.map.pageCheckbox.prop('checked', false);
        $this.map.addAllCheckbox.prop('checked', false);
        $this.map.addPage.prop('disabled', true);
        $this.map.addItemModal.modal('toggle');

        return true;
    },

    addLinkFormSubmit: function(element) {
        var $this = this,
            form = $(element),
            linkName = form.find($this.map.linkNameInput).val(),
            url = form.find($this.map.urlInput).val();

        if (form.find('.has-error').length == 0) {
            $this.addMenuItem($this.TYPE_LINK, linkName, null, url);
            $this.closeAddItemModal(form);
        }

        return false;
    },

    addTextFormSubmit: function(element) {
        var $this = this,
            form = $(element),
            linkName = form.find($this.map.linkNameInput).val();

        if (form.find('.has-error').length == 0) {
            $this.addMenuItem($this.TYPE_TEXT, linkName);
            $this.closeAddItemModal(form);
        }

        return false;
    },

    addMenuItem: function(type, linkName, pageId, url) {
        var $this = this,
            itemTemplate = $this.map.itemTemplate.html();

        $this.newItemsAmount++;

        itemTemplate = itemTemplate.replace('items_0', 'items_new' + $this.newItemsAmount)
            .replace(new RegExp(/MenuItem\[0\]/g), 'NewItem[' + $this.newItemsAmount + ']')
            .replace(new RegExp(/MenuItemI18n\[0\]/g), 'NewItemI18n[' + $this.newItemsAmount + ']')
            .replace(new RegExp(/menuitem\-0\-link_name/g), 'menuitem-' + $this.newItemsAmount + '-link_name')
            .replace(new RegExp(/menuitem\-0\-url/g), 'menuitem-' + $this.newItemsAmount + '-url')
        ;

        $this.map.sortable.append(itemTemplate);
        var newItem = $this.map.sortable.find('> li:last-child');

        newItem.find($this.map.nameClass).html(linkName);
        newItem.find($('#menuitem-' + $this.newItemsAmount + '-link_name')).val(linkName);
        newItem.find($this.map.typeInput).val(type);

        var itemType = newItem.find($this.map.typeClass);
        if (itemType.find('.type-' + type).length > 0) {
            itemType.find('.type-' + type).removeClass('hidden');
        } else {
            itemType.addClass('hidden');
        }

        if (type == $this.TYPE_PAGE) {
            newItem.find($this.map.pageSelect).val(pageId);
        } else {
            newItem.find($this.map.pageSelect).parents($this.map.inputContainer).parent().hide();
            newItem.find($this.map.linkNames).removeClass('hidden');
        }
        if (type == $this.TYPE_LINK) {
            newItem.find($('#menuitem-' + $this.newItemsAmount + '-url')).val(url);
            newItem.find($('#menuitem-' + $this.newItemsAmount + '-url')).parents($this.map.inputContainer).parent().removeClass('hidden');
        }

        $this.map.empty.addClass('hidden');
        $this.map.itemTab.tab('show');
        $('.menu-form form#w0').yiiActiveForm('add', {
            'id': 'menuitem-' + $this.newItemsAmount + '-url',
            'name': '[' + $this.newItemsAmount + ']url',
            'container': '.field-menuitem-' + $this.newItemsAmount + '-url',
            'input': '#menuitem-' + $this.newItemsAmount + '-url',
            'error': '.text-danger',
            'validate': function (attribute, value, messages, deferred, $form) {
                yii.validation.string(value, messages, {
                    "message": "Url must be a string.",
                    "max": 255,
                    "tooLong": "Url should contain at most 255 characters.",
                    "skipOnEmpty": 1
                });
                yii.validation.url(value, messages, {
                    "pattern": /^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(?::\d{1,5})?(?:$|[?\/#])/i,
                    "message": "Url is not a valid URL.",
                    "enableIDN": false,
                    "skipOnEmpty": 1,
                    "defaultScheme": "http"
                });
            }
        });
        $('.menu-form form#w0').yiiActiveForm('add', {
            'id': 'menuitem-' + $this.newItemsAmount + '-linkname',
            'name': '[' + $this.newItemsAmount + ']linkname',
            'container': '.field-menuitem-' + $this.newItemsAmount + '-link_name',
            'input': '#menuitem-' + $this.newItemsAmount + '-link_name',
            'error': '.text-danger',
            'validate': function (attribute, value, messages, deferred, $form) {
                yii.validation.required(value, messages, {"message": "Link Caption cannot be blank."});
                yii.validation.string(value, messages, {
                    "message": "Link Caption must be a string.",
                    "max": 100,
                    "tooLong": "Link Caption should contain at most 100 characters.",
                    "skipOnEmpty": 1
                });
            }
        });

        return true;
    },

    openAddItemTab: function(tab) {
        tab.tab('show');
        return true;
    },

    closeAddItemModal: function(form) {
        var $this = this;

        form.find($this.map.linkNameInput).val('');
        form.find($this.map.urlInput).val('');
        form.find($this.map.successClass).removeClass($this.map.successClass.substring(1));
        $this.map.addItemModal.modal('toggle');

        return false;
    },

    toggleDetailClick: function(element, visible) {
        var $this = this,
            containers = $this.map.sortable.find($this.map.detailContainer),
            hideClass = $this.map.detailDownClass,
            showClass = $this.map.detailUpClass;

        if (visible == undefined) {
            visible = $this.map.sortable.find($this.map.detailContainer + ':visible').length == 0;
        }

        if (visible) {
            containers.show(200);
        } else {
            containers.hide(200);
            hideClass = $this.map.detailUpClass;
            showClass = $this.map.detailDownClass;
        }

        $this.map.sortable.find(hideClass).removeClass(hideClass.substring(1)).addClass(showClass.substring(1));

        return true;
    },

    inheritedSelectChange: function(element) {
        var $this = this;

        $(element).closest($this.map.containerClass).find($this.map.linkNames).toggleClass('hidden');

        return false;
    }
}

$(function() {
    MenuHelper.init();
});