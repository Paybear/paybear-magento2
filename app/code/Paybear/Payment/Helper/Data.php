<?php


namespace Paybear\Payment\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const API_DOMAIN = 'https://api.paybear.io';
    const API_DOMAIN_TEST = 'http://test.paybear.io';
    const EMAIL_TEMPLATE_UNDERPAIMENT = 'paybear_underpayment_email';
    const EMAIL_TEMPLATE_OVERPAIMENT = 'paybear_overpayment_email';

    protected $currency;
    protected $jsonHelper;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Directory\Model\Currency $currency,
        \Magento\Framework\Json\Helper\Data $jsonHelper

    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->currency = $currency;
        $this->jsonHelper = $jsonHelper;
    }

    public function getApiDomain()
    {

        $testnet = $this->scopeConfig->getValue('payment/paybear/testnet', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if ($testnet) {
            return self::API_DOMAIN_TEST;
        } else {
            return self::API_DOMAIN;
        }
    }

    public function getApiSecretKey()
    {
        return $this->scopeConfig->getValue('payment/paybear/api_secret', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getMaxunderpaymentfiat()
    {
        $underpayment = $this->scopeConfig->getValue('payment/paybear/maxunderpaymentfiat', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $underpayment = !empty($underpayment) ? $underpayment : 0.01;
        return $underpayment;
    }

    public function getMinoverpaymentfiat()
    {
        $overpaiment = $this->scopeConfig->getValue('payment/paybear/minoverpaymentfiat', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $overpaiment = !empty($overpaiment) ? $overpaiment : 1;
        return $overpaiment;
    }

    public function getExchangeLocktime()
    {
        $exchange_locktime = $this->scopeConfig->getValue('payment/paybear/exchange_locktime', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $exchange_locktime = !empty($exchange_locktime) ? $exchange_locktime : 15;
        return $exchange_locktime;
    }

    public function log($data, $file_mame = 'paybear.log')
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/' . $file_mame);
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        if (is_object($data) || (is_array($data))) {
            $logger->info(print_r($data, true));
        } else {
            $logger->info($data);
        }
    }

    public function getCurrentCurrencySymbol()
    {
        return $this->currency->getCurrencySymbol();
    }

    public function sanitize_token($token)
    {
        $token = strtolower($token);
        $token = preg_replace('/[^a-z0-9:]/', '', $token);
        return $token;
    }

    public function jsonEncode(array $dataToEncode)
    {
        $encodedData = $this->jsonHelper->jsonEncode($dataToEncode);

        return $encodedData;
    }

}
