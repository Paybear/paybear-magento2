<?php


namespace Paybear\Payment\Model\Payment;

class Paybear extends \Magento\Payment\Model\Method\AbstractMethod
{

    protected $_code = "paybear";
    protected $_isOffline = true;
}
