'use strict';

var SnippetHelper = {
    map: {},

    VISIBLE_ON_SELECTED: 2,

    _map: function() {
        var $this = this;
        $this.map = {
            snippetVisibleInput: $('select#snippet-visible'),
            snippetPageIdsBlock: $('div.snippet-page-ids')
        };
    },

    init: function() {
        var $this = this;
        $this._map();
        $this.map.snippetVisibleInput.change(function() { return $this.snippetVisibleChange(this); });
    },

    snippetVisibleChange: function(element) {
        var $this = this;

        if ($(element).val() == $this.VISIBLE_ON_SELECTED) {
            $this.map.snippetPageIdsBlock.removeClass('hidden');
        } else {
            $this.map.snippetPageIdsBlock.addClass('hidden');
        }

        return false;
    }
};

$(function() {
    SnippetHelper.init();
});