<?php
namespace Paybear\Payment\Controller\Payment;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Sales\Model\Order;
use Paybear\Payment\Model\Payment;
use Paybear\Payment\Model\Paymenttxn;
use Paybear\Payment\Model\Address;

use Magento\Sales\Model\Order\Status;


class Test extends Action
{
    protected $order;
    protected $paybearPayment;
    protected $paybearPaymenttxn;
    protected $address;
    protected $helper;

    protected $_orderRepository;

    protected $orderStatus;

    public function __construct(
        Context $context,
        Order $order,
        Payment $paybearPayment,
        Paymenttxn $paybearPaymenttxn,
        Address $address,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Paybear\Payment\Helper\Data $helper,
        Status $orderStatus


    )
    {
        parent::__construct($context);

        $this->order = $order;
        $this->paybearPayment = $paybearPayment;

        $this->paybearPaymenttxn = $paybearPaymenttxn;
        $this->address = $address;

        $this->_orderRepository = $orderRepository;

        $this->helper = $helper;

        $this->orderStatus = $orderStatus;
    }

    public function execute()
    {

    }

}
