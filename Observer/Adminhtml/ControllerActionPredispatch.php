<?php

namespace Metagento\Core\Observer\Adminhtml;

use Magento\Backend\Model\Auth\Session;
use Metagento\Core\Helper\Data;
use Metagento\Core\Model\FeedFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ControllerActionPredispatch implements ObserverInterface
{
    protected $_backendAuthSession;
    protected $helper;
    protected $feedFactory;

    /**
     * @param Session $backendAuthSession
     * @param Data $helper
     * @param FeedFactory $feedFactory
     */
    public function __construct(
        Session $backendAuthSession,
        Data $helper,
        FeedFactory $feedFactory
    ) {
        $this->_backendAuthSession = $backendAuthSession;
        $this->helper = $helper;
        $this->feedFactory = $feedFactory;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($this->_backendAuthSession->isLoggedIn()
            && $this->helper->isModuleOutputEnabled('Magento_AdminNotification')
        ) {
            /** @var \Metagento\Core\Model\Feed $feed */
            $feed = $this->feedFactory->create();
            $feed->checkUpdate();
        }
    }
}
