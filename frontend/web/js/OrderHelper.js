var OrderHelper = {
    map: {},

    _map: function() {
        var $this = this;
    	$this.map = {
            selectAmount: $('table.cart-list select.amount'),
            selectCountry: $('form#checkout-form select#order-country_id'),
            cartPrice: $('form#checkout-form #cart-price'),
            vatTax: $('form#checkout-form #vat-tax'),
            totalPrice: $('form#checkout-form #total-price')
        };
    },
    
    init: function() {
        var $this = this;
        $this._map();
        $this.map.selectAmount.change(function() { return $this.selectAmountChange(this); });
        $this.map.selectCountry.change(function() { return $this.selectCountryChange(this); });
    },

    selectAmountChange: function(select) {
        $(select).parent('form').submit();
    },

    selectCountryChange: function(select) {
        var $this = this,
            countryId = $(select).val(),
            cartPrice = parseInt($this.map.cartPrice.text(), 10);

        $.ajax({
            url: '/order/price',
            data: {'country_id': countryId},
            type: 'POST',
            success: function (response) {
                var vatTax = parseInt(response.vatTax, 10);
                $this.map.vatTax.text(vatTax);
                $this.map.totalPrice.text(cartPrice + cartPrice * vatTax / 100);
            }
        });
    }
};

$(function() {
    OrderHelper.init();
});