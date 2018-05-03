<?php
/**
 * Created by PhpStorm.
 * User: Igor S. Dev
 * Date: 19-Apr-18
 * Time: 13:23
 */
namespace Paybear\Payment\Model;

/**
 * @method \Paybear\Payment\Model\ResourceModel\Address getResource()
 * @method \Paybear\Payment\Model\ResourceModel\Address\Collection getCollection()
 */
class Address extends \Magento\Framework\Model\AbstractModel implements \Paybear\Payment\Api\Data\AddressInterface,
    \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'paybear_payment_address';
    protected $_cacheTag = 'paybear_payment_address';
    protected $_eventPrefix = 'paybear_payment_address';

    protected function _construct()
    {
        $this->_init('Paybear\Payment\Model\ResourceModel\Address');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function get($order_id, $token)
    {

        $addressObject = $this->getCollection()->addFieldToFilter('order_id', $order_id)->addFieldToFilter('token', $token)->getFirstItem();

        if ($addressObject->getId()) {
            return $addressObject;
        }

        return null;
    }
}