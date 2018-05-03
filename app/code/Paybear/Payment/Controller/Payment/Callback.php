<?php
namespace Paybear\Payment\Controller\Payment;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Sales\Model\Order;
use Paybear\Payment\Model\Payment;
use Paybear\Payment\Model\Paymenttxn;

use Magento\Framework\App\Request\Http;

class Callback extends Action
{
    protected $order;
    protected $paybearPayment;
    protected $helper;

    protected $paybearPaymenttxn;

    public function __construct(
        Context $context,
        Order $order,
        Payment $paybearPayment,
        \Paybear\Payment\Helper\Data $helper,
        Paymenttxn $paybearPaymenttxn,
        Http $request
    )
    {
        $this->order = $order;
        $this->paybearPayment = $paybearPayment;
        $this->helper = $helper;

        $this->paybearPaymenttxn = $paybearPaymenttxn;

        $this->request = $request;

        parent::__construct($context);
    }

    public function execute()
    {
        $data = file_get_contents('php://input');
        $params = $this->request->getParams();
        $order_id = (int)$params['order'];

        $response = $this->paybearPayment->checkCallback($data, $order_id);

        $this->getResponse()->setBody($response);
    }

}
