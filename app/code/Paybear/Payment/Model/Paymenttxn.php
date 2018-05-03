<?php
/**
 * Created by PhpStorm.
 * User: Igor S. Dev
 * Date: 06-Apr-18
 * Time: 16:10
 */
namespace Paybear\Payment\Model;

/**
 * @method \Paybear\Payment\Model\ResourceModel\Paymenttxn getResource()
 * @method \Paybear\Payment\Model\ResourceModel\Paymenttxn\Collection getCollection()
 */
class Paymenttxn extends \Magento\Framework\Model\AbstractModel implements \Paybear\Payment\Api\Data\PaymenttxnInterface,
    \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'paybear_payment_paymenttxn';
    protected $_cacheTag = 'paybear_payment_paymenttxn';
    protected $_eventPrefix = 'paybear_payment_paymenttxn';

    protected function _construct()
    {
        $this->_init('Paybear\Payment\Model\ResourceModel\Paymenttxn');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getTxnConfirmations($order_id)
    {

        $txns = $this->getCollection()
            ->addFieldToFilter('order_id', $order_id);
        $confirmations = array();
        if ($txns->getSize() > 0)
            foreach ($txns as $txn) {
                $confirmations[] = $txn->getConfirmation();
            }

        return (count($confirmations)) ? min($confirmations) : null;
    }

    public function getTotalConfirmed($order_id, $maxConfirmations)
    {

        $txns = $this->getCollection()
            ->addFieldToFilter('order_id', $order_id);
        $totalConfirmed = 0;
        if ($txns->getSize() > 0)
            foreach ($txns as $txn) {
                if ($txn->getConfirmation() >= $maxConfirmations) {
                    $totalConfirmed += $txn->getTxnAmount();
                }
            }

        return $totalConfirmed;
    }

    public function getTotalUnconfirmed($order_id, $maxConfirmations)
    {
        $txns = $this->getCollection()
            ->addFieldToFilter('order_id', $order_id);
        $totalUnConfirmed = 0;
        if ($txns->getSize() > 0)
            foreach ($txns as $txn) {
                if ($txn->getConfirmation() < $maxConfirmations) {
                    $totalUnConfirmed += $txn->getTxnAmount();
                }
            }

        return $totalUnConfirmed;
    }

    public function getTotalPaid($order_id)
    {
        $txns = $this->getCollection()
            ->addFieldToFilter('order_id', $order_id);
        $total = 0;
        if ($txns->getSize() > 0)
            foreach ($txns as $txn) {
                $total += $txn->getTxnAmount();
            }

        return $total;
    }

    public function isNewOrder($order_id)
    {
        $txns = $this->getCollection()
            ->addFieldToFilter('order_id', $order_id);

        if ($txns->getSize() > 0) {
            return false;
        } else {
            return true;
        }
    }
}