<?php
/**
 * Created by PhpStorm.
 * User: Igor S. Dev
 * Date: 06-Apr-18
 * Time: 16:10
 */
namespace Paybear\Payment\Model\ResourceModel;

class Paymenttxn extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        $this->_init('paybear_payment_txn', 'id');
    }

}