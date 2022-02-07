<?php
/*
 * Copyright © 2021, 2022 Oracle and/or its affiliates.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Optin\Model;

class Observer extends \Bronto\M2\Optin\ExtensionAbstract
{
    protected $_checkout;

    /**
     * @param \Magento\Checkout\Model\Session $checkout
     * @param \Bronto\M2\Core\Subscriber\ManagerInterface $subscribers
     * @param \Bronto\M2\Core\App\EmulationInterface $appEmulation
     * @param \Bronto\M2\Core\Store\ManagerInterface $storeManager
     * @param \Bronto\M2\Connector\QueueManagerInterface $queueManager
     * @param \Bronto\M2\Connector\SettingsInterface $connectorSettings
     * @param \Bronto\M2\Connector\Event\PlatformInterface $platform
     * @param \Bronto\M2\Optin\Event\Source $source
     * @param \Bronto\M2\Optin\SettingsInterface $helper
     * @param \Magento\Framework\Filesystem\DriverInterface $fileSystemDriver
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkout,
        \Bronto\M2\Core\Subscriber\ManagerInterface $subscribers,
        \Bronto\M2\Core\App\EmulationInterface $appEmulation,
        \Bronto\M2\Core\Store\ManagerInterface $storeManager,
        \Bronto\M2\Connector\QueueManagerInterface $queueManager,
        \Bronto\M2\Connector\SettingsInterface $connectorSettings,
        \Bronto\M2\Connector\Event\PlatformInterface $platform,
        \Bronto\M2\Optin\Event\Source $source,
        \Bronto\M2\Optin\SettingsInterface $helper,
        \Magento\Framework\Filesystem\DriverInterface $fileSystemDriver,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct(
            $subscribers,
            $appEmulation,
            $storeManager,
            $queueManager,
            $connectorSettings,
            $helper,
            $platform,
            $source,
            $fileSystemDriver,
            $logger
        );
        $this->_checkout = $checkout;
    }

    /**
     * @see parent
     */
    public function translate($message)
    {
        return __($message);
    }

    /**
     * @see parent
     */
    public function subscribeAfterCheckout($observer)
    {
        $quote = $observer->getQuote();
        $optin = (bool) $this->_checkout->getSubscribeToNewsletter();
        $this->_subscribeAfterCheckout(
            $quote->getStoreId(),
            $quote->getCustomerEmail(),
            $optin
        );
    }

    /**
     * @see parent
     */
    protected function _checkoutLayouts()
    {
        $layouts = parent::_checkoutLayouts();
        unset($layouts[1]);
        unset($layouts[3]);
        return $layouts;
    }
}
