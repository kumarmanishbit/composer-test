<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Order\Observer;

use Bronto\M2\Connector\SettingsInterface;
use Bronto\M2\Impl\Core\Cookies;
use Bronto\M2\Impl\Core\Logger;
use Bronto\Order\Model\Observer as BrontoObserver;
use Magento\Framework\Event\Observer;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class AfterOrderPlacedObserver
 *
 * Instructions for after an order is placed
 *
 * @package Bronto\Order\Observer
 */
class AfterOrderPlacedObserver extends ObserverAbstract
{
    /** @var SettingsInterface */
    protected $settings;

    /** @var StoreManagerInterface */
    protected $storeManager;

    /** @var Cookies */
    protected $cookies;

    /** @var CookieMetadataFactory */
    protected $cookieMetadataFactory;

    /**
     * AfterOrderPlacedObserver constructor.
     * @param Observer $observer
     * @param SettingsInterface $settings
     * @param StoreManagerInterface $storeManager
     * @param Cookies $cookies
     * @param CookieMetadataFactory $cookieMetadataFactory
     */
    public function __construct(
        BrontoObserver $observer,
        SettingsInterface $settings,
        StoreManagerInterface $storeManager,
        Cookies $cookies,
        CookieMetadataFactory $cookieMetadataFactory
    ) {
        parent::__construct($observer);
        $this->settings = $settings;
        $this->storeManager = $storeManager;
        $this->cookies = $cookies;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
    }

    /**
     * @see ObserverAbstract::execute
     * @param ObserverInterface $observer
     */
    public function execute(Observer $observer)
    {
        // Delete a TID cookie if it exists
        $tidKey = $this->settings->getTidKey('store', $this->storeManager->getStore()->getId());
        $tidValue = $this->cookies->getCookie($tidKey, null);
        if ($tidValue) {
            $metadata = $this->cookieMetadataFactory->createCookieMetadata()->setPath('/');
            $this->cookies->deleteCookie($tidKey, $metadata);
        }
    }
}
