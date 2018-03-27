define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'paybear',
                component: 'Paybear_Payment/js/view/payment/method-renderer/paybear-method'
            }
        );
        return Component.extend({});
    }
);