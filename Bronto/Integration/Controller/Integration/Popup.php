<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Integration\Controller\Integration;

class Popup extends \Magento\Framework\App\Action\Action
{
    const EMAIL_PARAM = 'emailAddress';

    protected $_subscribers;
    protected $_integration;
    protected $_storeManager;
    protected $_logger;

    /**
     * @param \Bronto\M2\Core\Subscriber\ManagerInterface $subscribers
     * @param \Bronto\M2\Core\Store\ManagerInterface $storeManager
     * @param \Bronto\M2\Core\Log\LoggerInterface $logger
     * @param \Bronto\M2\Integration\PopupSettingsInterface $integration
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Bronto\M2\Core\Subscriber\ManagerInterface $subscribers,
        \Bronto\M2\Core\Store\ManagerInterface $storeManager,
        \Bronto\M2\Core\Log\LoggerInterface $logger,
        \Bronto\M2\Integration\PopupSettingsInterface $integration,
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->_logger = $logger;
        $this->_subscribers = $subscribers;
        $this->_integration = $integration;
        $this->_storeManager = $storeManager;
    }

    /**
     * @see parent
     */
    public function execute()
    {
        $emailAddress = $this->getRequest()->getParam(self::EMAIL_PARAM);
        $currentStore = $this->_storeManager->getStore(true);
        if ($this->_integration->isCreateSubscribers('store', $currentStore)) {
            try {
                $this->_subscribers->subscribe($emailAddress, true);
            } catch (\Exception $e) {
                $this->_logger->critical($e);
            }
        }
        return $this->getResponse();
    }
}
