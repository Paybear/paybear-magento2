<?php
namespace Paybear\Payment\Controller\Payment;


use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Sales\Model\OrderFactory;
use Paybear\Payment\Model\Payment\Paybear;

class Payment extends Action
{
    protected $orderFactory;
    protected $coingatePayment;
    protected $checkoutSession;

    public function __construct(
        Context $context,
        OrderFactory $orderFactory,
        Session $checkoutSession,
        Paybear $paybearPayment
    )
    {
        parent::__construct($context);

        $this->orderFactory = $orderFactory;
        $this->paybearPayment = $paybearPayment;
        $this->checkoutSession = $checkoutSession;
    }

    public function execute()
    {
        return $this->resultFactory->create('page');
    }
}
