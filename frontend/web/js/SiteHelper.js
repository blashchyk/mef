var SiteHelper = {
    map: {},

    _map: function() {
        var $this = this;
        $this.map = {
            actionLink: $('a.action-link'),
            userBirthday: $('input#user-birthday'),
            datePicker: $('input#date-picker')
        };
    },

    init: function() {
        var $this = this;
        $this._map();
        $this.map.actionLink.click(function() { return $this.actionLinkClick(this); });
        $this.map.datePicker.change(function() { return $this.datePickerChange(this); });
    },

    actionLinkClick: function(link) {
        var $this,
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

    datePickerChange: function(element){
        var $this = this;

        $this.map.userBirthday.change();

        return true;
    }
};

$(function() {
    SiteHelper.init();
});