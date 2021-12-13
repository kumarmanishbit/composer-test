<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Cart\Model\Observer;

class AfterBrontoSiteFiddleObserver extends ObserverAbstract
{
    const CART_FIDDLE = 'bronto_cart_fiddle';

    protected $_checkout;
    protected $_eventManager;
    protected $_settings;

    /**
     * @param \Bronto\M2\Cart\SettingsInterface $settings
     * @param \Bronto\M2\Core\Sales\CheckoutSessionInterface $checkout
     * @param \Bronto\M2\Core\Event\ManagerInterface $eventManager
     */
    public function __construct(
        \Bronto\Cart\Model\Observer $observer,
        \Bronto\M2\Cart\SettingsInterface $settings,
        \Bronto\M2\Core\Sales\CheckoutSessionInterface $checkout,
        \Bronto\M2\Core\Event\ManagerInterface $eventManager
    ) {
        parent::__construct($observer);
        $this->_checkout = $checkout;
        $this->_eventManager = $eventManager;
        $this->_settings = $settings;
    }

    /**
     * @see parent
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->_isEnabled()) {
            $this->_eventManager->dispatch(self::CART_FIDDLE, [
                'quote' => $this->_checkout->getQuote()->setUpdatedAt(date('c'))
            ]);
        }
    }

    /**
     * Runs through a variety of checks to determined if the event
     * should be forwarded
     *
     * @return boolean
     */
    protected function _isEnabled()
    {
        return (
            $this->_checkout->getQuoteId() &&
            $this->_checkout->getQuote()->getIsActive()
        );
    }
}
