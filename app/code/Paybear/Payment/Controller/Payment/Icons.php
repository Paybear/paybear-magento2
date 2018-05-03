<?php
namespace Paybear\Payment\Controller\Payment;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Sales\Model\Order;
use Paybear\Payment\Model\Payment;
use Paybear\Payment\Model\Paymenttxn;
use Paybear\Payment\Model\Address;


use Magento\Framework\App\Request\Http;

class Icons extends Action
{
    protected $order;
    protected $paybearPayment;
    protected $paybearPaymenttxn;
    protected $address;

    public function __construct(
        Context $context,
        Order $order,
        Payment $paybearPayment,
        Paymenttxn $paybearPaymenttxn,
        Address $address,
        Http $request
    )
    {
        $this->order = $order;
        $this->paybearPayment = $paybearPayment;

        $this->paybearPaymenttxn = $paybearPaymenttxn;
        $this->address = $address;

        $this->request = $request;

        parent::__construct($context);
    }

    public function execute()
    {
        $data = array();

        $params = $this->request->getParams();
        $nums = (int)$params['nums'];

        $currencies = array_slice($this->paybearPayment->getCurrencies(), 0, $nums);
        $_html = '';

        if (count($currencies) > 0) {
            foreach ($currencies as $code => $currency) {
                $_html .= sprintf('<img src="%s" alt="%s" width="%spx" height="%spx" />', $currency['icon'], $currency['code'], 30, 30);
            }

        }

        $data['icons'] = $_html;

        $this->getResponse()->setBody(
            json_encode($data)

        );
    }

}
