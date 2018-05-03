<?php
/**
 * Created by PhpStorm.
 * User: Igor S. Dev
 * Date: 19-Apr-18
 * Time: 13:23
 */
namespace Paybear\Payment\Model\ResourceModel;

class Address extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        $this->_init('paybear_address', 'id');
    }

}