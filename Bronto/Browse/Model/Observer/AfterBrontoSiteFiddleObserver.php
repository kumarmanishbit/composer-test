<?php
/*
 * Copyright © 2021, 2022 Oracle and/or its affiliates.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Browse\Model\Observer;

class AfterBrontoSiteFiddleObserver implements \Magento\Framework\Event\ObserverInterface
{
    protected $_settings;
    protected $_eventManager;
    protected $_storeManager;

    /**
     * @param \Bronto\M2\Browse\SettingsInterface $settings
     * @param \Bronto\M2\Core\Event\ManagerInterface $eventManager
     * @param \Bronto\M2\Core\Store\ManagerInterface $storeManager
     */
    public function __construct(
        \Bronto\M2\Browse\SettingsInterface $settings,
        \Bronto\M2\Core\Event\ManagerInterface $eventManager,
        \Bronto\M2\Core\Store\ManagerInterface $storeManager
    ) {
        $this->_settings = $settings;
        $this->_eventManager = $eventManager;
        $this->_storeManager = $storeManager;
    }

    /**
     * @see parent
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $currentStore = $this->_storeManager->getStore(true);
        if ($this->_settings->isEnabled('store', $currentStore)) {
            $this->_eventManager->dispatch('bronto_browse_event', [
                'request' => $observer->getRequest(),
                'url' => $observer->getRequest()->getParam('currentUrl'),
                'event_type' => 'VISIT',
            ]);
        }
    }
}
