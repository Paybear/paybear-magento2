<?php
namespace Paybear\Payment\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Psr\Log\LoggerInterface as Logger;

use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Framework\App\Config\Storage\Writer as ConfigWriter;

class Payment implements ObserverInterface
{
    protected $paybearPayment;

    protected $_messageManager;


    protected $configWriter;

    protected $helper;


    /**
     * @param Logger $logger
     */
    public function __construct(
        Logger $logger,

        ConfigWriter $configWriter,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        ConfigWriter $scopeConfig,
        \Paybear\Payment\Helper\Data $helper,
        \Paybear\Payment\Model\Payment $paybearPayment
    )
    {
        $this->logger = $logger;


        $this->_messageManager = $messageManager;
        $this->configWriter = $configWriter;
        $this->scopeConfig = $scopeConfig;

        $this->helper = $helper;
        $this->paybearPayment = $paybearPayment;
    }

    public function execute(EventObserver $observer)
    {

        $event           = $observer->getEvent();
        $method          = $event->getMethodInstance();
        $result          = $event->getResult();


        if($method->getCode() == 'paybear') {
            $response = $this->paybearPayment->checkPayBearResponse();
            $disable = false;

            if (empty($response)) {
                $disable = true;
                $this->helper->log('Unable to connect to PayBear. Please check your network or contact support.');
            }

            if (isset($response['data']) && (empty($response['data']))) {
                $disable = true;
                $this->helper->log('You do not have any currencies enabled, please enable them to your Merchant Dashboard');
            }

            if ($disable===true) {
                $result->setData( 'is_available', false);
            }
        }

    }
}
