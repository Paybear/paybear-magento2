<?php
namespace Paybear\Payment\Controller\Payment;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Sales\Model\Order;
use Paybear\Payment\Model\Payment;
use Paybear\Payment\Helper\Data;
use Magento\Framework\App\Request\Http;


class Currencies extends Action
{
    protected $order;
    protected $paybearPayment;


    protected $_orderRepository;

    public function __construct(
        Context $context,
        Order $order,
        Payment $paybearPayment,
        Http $request,
        Data $helper,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
    )
    {
        $this->order = $order;
        $this->paybearPayment = $paybearPayment;
        $this->request = $request;
        $this->helper = $helper;

        $this->_orderRepository = $orderRepository;

        parent::__construct($context);

    }

    public function execute()
    {
        $params = $this->request->getParams();
        $order_id = (int)$params['order'];
        $order_currency_code = $params['order_currency_code'];
        $order = $this->_orderRepository->get($order_id);
        $token = 'all';

        if ($order->getId()) {
            if (isset($params['token'])) $token = $params['token'];
            $this->getResponse()->setBody($this->paybearPayment->getCurrenciesJson((float)$order->getGrandTotal(), $order_id, $order_currency_code, $token));
        }


    }
}
