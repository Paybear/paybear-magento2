define([
    'jquery'
], function ($j) {

    return function (paybear) {


        if (paybear.config.fiat_value > 0) {
            window.paybear = new Paybear({
                button: '#paybear-all',
                fiatValue: paybear.config.fiat_value,
                currencies: paybear.config.currencies,
                statusUrl: paybear.config.status_url,
                redirectTo: paybear.config.redirect_url,
                fiatCurrency: paybear.config.currency_iso,
                fiatSign: paybear.config.currency_sign,
                minOverpaymentFiat: parseFloat(paybear.config.min_overpayment_fiat),
                maxUnderpaymentFiat: parseFloat(paybear.config.max_underpayment_fiat),
                modal: true,
                enablePoweredBy: true
            });
        }


    }
});