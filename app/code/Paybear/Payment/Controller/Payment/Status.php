<?php
namespace Paybear\Payment\Controller\Payment;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Sales\Model\Order;
use Paybear\Payment\Model\Payment;
use Paybear\Payment\Model\Paymenttxn;
use Paybear\Payment\Model\Address;


use Magento\Framework\App\Request\Http;

class Status extends Action
{
    protected $order;
    protected $paybearPayment;
    protected $paybearPaymenttxn;
    protected $address;

    protected $helper;

    public function __construct(
        Context $context,
        Order $order,
        Payment $paybearPayment,
        Paymenttxn $paybearPaymenttxn,
        Address $address,
        Http $request,
        \Paybear\Payment\Helper\Data $helper
    )
    {
        $this->order = $order;
        $this->paybearPayment = $paybearPayment;

        $this->paybearPaymenttxn = $paybearPaymenttxn;
        $this->address = $address;

        $this->request = $request;
        $this->helper = $helper;

        parent::__construct($context);
    }

    public function execute()
    {
        $data = array();

        $params = $this->request->getParams();
        $order_id = (int)$params['order'];

        if (empty($order_id))
            return;

        $payment = $this->paybearPayment->load($order_id, 'order_id');
        $order = $this->order->load($order_id);

        $maxConfirmations = $payment->getMaxConfirmation();

        $totalConfirmations = $this->paybearPaymenttxn->getTxnConfirmations($order_id);
        $totalConfirmed = $this->paybearPaymenttxn->getTotalConfirmed($order_id, $maxConfirmations);

        $maxDifference_fiat = $this->helper->getMaxunderpaymentfiat();
        $maxDifference_coins = round($maxDifference_fiat / $this->paybearPayment->getRate($payment->getToken(), $order->getOrderCurrencyCode()), 8);
        $maxDifference_coins = max($maxDifference_coins, 0.00000001);

        if ($payment->getAmount() - $maxDifference_coins <= $totalConfirmed) {
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }

        if (is_numeric($totalConfirmations)) {
            $data['confirmations'] = $totalConfirmations;
        }

        $coinsPaid = $this->paybearPaymenttxn->getTotalPaid($order_id);

        if ($coinsPaid) {

            $underpayment = $payment->getAmount() - $coinsPaid;
            $email_flag = $payment->getEmailStatus();
            if (($underpayment > 0) && ($underpayment > $maxDifference_coins) && (empty($email_flag))) {

                $message = __(
                    "Looks like you underpaid %1 %2 (%3 %4). 
                    Don't worry, here is what to do next: 
                    - Contact the merchant directly and request details on how you can pay the difference or
                    - Request a refund and create a new order. 
                    Tips for Paying with Crypto: 
                    Tip 1) When paying, ensure you send the correct amount in %5. Do not manually enter the %6 Value. 
                    Tip 2) If you are sending from an exchange, be sure to correctly factor in their withdrawal fees.
                    Tip 3) Be sure to successfully send your payment before the countdown timer expires. 
                    This timer is setup to lock in a fixed rate for your payment. Once it expires, rates may change.",
                    $underpayment,
                    strtoupper($payment->getToken()),
                    round($underpayment * $payment->getRate($payment->getToken(), strtolower($order->getOrderCurrencyCode())), 2),
                    strtoupper($order->getOrderCurrencyCode()),
                    strtoupper($payment->getToken()),
                    strtoupper($order->getOrderCurrencyCode()));

                /** @var OrderCommentSender $orderCommentSender */
                $orderCommentSender = $this->_objectManager
                    ->create(\Magento\Sales\Model\Order\Email\Sender\OrderCommentSender::class);

                $orderCommentSender->send($order, true, $message);
                $payment->setEmailStatus(1);
                $payment->save();
            }
        }

        $data['coinsPaid'] = $coinsPaid;

        $this->getResponse()->setBody(
            json_encode($data)
        );
    }

}
