'use strict';

var RoleHelper = {
    map: {},

    TYPE_READ: 1,

    _map: function() {
        var $this = this;
    	$this.map = {
            typeCheckbox: $('th.select-type :checkbox'),
            moduleCheckbox: $('td.select-module :checkbox'),
            allCheckbox: $('table #select-all'),
            readCheckbox: $('td :checkbox[value="' + $this.TYPE_READ + '"]'),
            editCheckbox: 'td:not(.select-module) :checkbox[value!="' + $this.TYPE_READ + '"]',
        };
    },
    
    init: function() {
        var $this = this;
        $this._map();
        $this.map.typeCheckbox.change(function() { return $this.typeCheckboxChange(this); });
        $this.map.moduleCheckbox.change(function() { return $this.moduleCheckboxChange(this); });
        $this.map.readCheckbox.change(function() { return $this.readCheckboxChange(this); });
        $this.map.allCheckbox.change(function() { return $this.allCheckboxChange(this); });
        $this.setTypeCheckboxes($this.map.typeCheckbox);
        $this.setModuleCheckboxes($this.map.moduleCheckbox);
        $this.setAllCheckbox($this.map.allCheckbox);
    },

    typeCheckboxChange: function(checkbox) {
        var $this = this,
            isChecked = $(checkbox).prop('checked'),
            type = $(checkbox).data('type'),
            typeCheckboxes = $(checkbox).parents('table').find(':checkbox[value="' + type + '"]');

        typeCheckboxes.prop('checked', isChecked);
        if (type == $this.TYPE_READ) {
            typeCheckboxes.trigger('change');
        }

        return true;
    },

    moduleCheckboxChange: function(checkbox) {
        var $this = this,
            isChecked = $(checkbox).prop('checked'),
            parent = $(checkbox).parents('tr'),
            moduleCheckboxes = parent.find(':checkbox'),
            readCheckbox = parent.find('td:eq(1)').find(':checkbox');
        
        moduleCheckboxes.prop('checked', isChecked);
        readCheckbox.trigger('change');
        
        return true;
    },

    readCheckboxChange: function(checkbox) {
        var $this = this,
            isChecked = $(checkbox).prop('checked'),
            moduleCheckboxes = $(checkbox).parents('tr').find($this.map.editCheckbox);
        
        moduleCheckboxes.prop('disabled', !isChecked);
        
        return true;
    },

    allCheckboxChange: function(checkbox) {
        var $this = this,
            isChecked = $(checkbox).prop('checked'),
            moduleCheckboxes = $(checkbox).parents('table').find(':checkbox');
        
        moduleCheckboxes.prop('checked', isChecked);
        $this.map.readCheckbox.trigger('change');
        
        return true;
    },

    setTypeCheckboxes: function(checkboxes) {
        for (var i = 0; i < checkboxes.length; i++) {
            var checkbox = $(checkboxes[i]),
                type = checkbox.data('type'),
                notChecked  = checkbox.parents('table').find(':checkbox[value="' + type + '"]:not(:checked)');
            checkbox.prop('checked', (notChecked.length == 0));
        }
    },

    setModuleCheckboxes: function(checkboxes) {
        for (var i = 0; i < checkboxes.length; i++) {
            var checkbox = $(checkboxes[i]),
                notChecked = checkbox.parents('tr').find('td:not(:eq(0))').find(':checkbox:not(:checked)');
            checkbox.prop('checked', (notChecked.length == 0));
        }
    },

    setAllCheckbox: function(checkbox) {
        var notChecked = $(checkbox).parents('table').find('tr:not(:last-child)').find(':checkbox:not(:checked)');
        checkbox.prop('checked', (notChecked.length == 0));
    }
};

$(function() {
    RoleHelper.init();
});