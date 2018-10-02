'use strict';

var ImageHelper = {
    map: {},

    _map: function() {
        var $this = this;
        $this.map = {
            fileInput: $('input[type="file"].file-loading'),
            fileHidden: null
        };
    },

    init: function() {
        var $this = this;
        $this._map();

        if ($this.map.fileInput.length > 0) {
            $this.initFileName();
        }
    },

    initFileName: function() {
        var $this = this,
            inputName = $this.map.fileInput.attr('name'),
            inputValue = $this.map.fileInput.attr('value');
        
        $this.map.fileHidden = $('input[type="hidden"][name="' + inputName + '"]');
        $this.map.fileHidden.val(inputValue);

        return false;
    },

    clearInputName: function() {
        var $this = this;

        $this.map.fileInput.val(null);
        $this.map.fileHidden.val(null);

        return false;
    }
};

$(function() {
    ImageHelper.init();
});