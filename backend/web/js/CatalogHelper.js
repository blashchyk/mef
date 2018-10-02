'use strict';

var CatalogHelper = {
    map: {},

    _map: function() {
        var $this = this;
        $this.map = {
            filterCategory: $('.filter-form #filter-category_id'),
            filterField: $('.filter-form #filter-field'),
            dynamicFormWrapper: $('.dynamicform_wrapper'),
            emptyListMessage: $('.empty-list-message'),
            dynamicFormItem: '.item',
            deleteFormItem: '.remove-item'
        };
    },

    init: function() {
        var $this = this;
        $this._map();

        $this.map.filterCategory.on('change', function(element) { $this.changeFilterCategory(element); });
        $this.map.dynamicFormWrapper.on("afterInsert", function(e, item) { $this.checkItemNumber() });
        $this.map.dynamicFormWrapper.on("afterDelete", function(e) { $this.checkItemNumber() });
        $this.map.dynamicFormWrapper.on("beforeDelete", function(e) { return $this.beforeDeleteItem() });
    },

    changeFilterCategory: function(element) {
        var $this = this,
            categoryId = $this.map.filterCategory.val(),
            field = $this.map.filterField.val();

        $.ajax({
            url: 'fields',
            type: 'POST',
            data: {
                categoryId: categoryId,
                field: field
            },
            success: function (response) {
                $this.map.filterField.html(null).append($('<option>'));
                for (var item in response.list) {
                    $this.map.filterField.append($('<option>', {value: item, selected: item == field, text: response.list[item]}));
                }
            }
        });
    },

    checkItemNumber: function() {
        var $this = this;

        if ($this.map.dynamicFormWrapper.find($this.map.dynamicFormItem).length > 0) {
            $this.map.emptyListMessage.addClass('hidden');
        } else {
            $this.map.emptyListMessage.removeClass('hidden');
        }
    },

    beforeDeleteItem: function() {
        var $this = this;
        return confirm($this.map.dynamicFormWrapper.find($this.map.deleteFormItem).data('message'));
    }
};

$(function() {
    CatalogHelper.init();
});