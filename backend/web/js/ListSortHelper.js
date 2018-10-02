'use strict';

var ListSortHelper = {
    map: {},

    _map: function() {
        var $this = this;
        $this.map = {
            sortingInput: $('input#sorted-list')
        };
    },

    init: function() {
        var $this = this;
        $this._map();
    },

    sortingUpdate: function() {
        var $this = this,
            sortedList = $this.map.sortingInput.val(),
            url = $this.map.sortingInput.data('url');

        $.ajax({
            url: url,
            type: 'POST',
            data: {sortedList: sortedList},
            success: function (response) {}
        });

        return false;
    }
};

$(function() {
    ListSortHelper.init();
});