<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Cart\Block;

use Magento\Customer\CustomerData\SectionSourceInterface;

class Fiddle extends \Magento\Framework\View\Element\Template implements SectionSourceInterface
{
    protected $_settings;
    protected $_checkout;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Bronto\M2\Cart\SettingsInterface $settings
     * @param \Bronto\M2\Core\Sales\CheckoutSessionInterface $checkout
     * @param array $data = []
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Bronto\M2\Cart\SettingsInterface $settings,
        \Bronto\M2\Core\Sales\CheckoutSessionInterface $checkout,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_settings = $settings;
        $this->_checkout = $checkout;
    }

    /**
     * Determines if any cart is in session
     *
     * @return boolean
     */
    public function isCartRecoveryEnabled()
    {
        return (
            $this->_checkout->getQuoteId() &&
            $this->_settings->isCartRecoveryEnabled('store', $this->_storeManager->getStore(true))
        );
    }

    /**
     * Gets the fiddle url for AJAXy related fiddles
     *
     * @return string
     */
    public function getFiddleUrl()
    {
        $currentStore = $this->_storeManager->getStore(true);
        return $this->getUrl('bcart/cart/fiddle', [
            '_secure' => $currentStore->isCurrentlySecure()
        ]);
    }

    /**
     * @see SectionSourceInterface::getSectionData
     * @return array
     */
    public function getSectionData()
    {
        $data = [];
        if ($this->isCartRecoveryEnabled()) {
            $quoteId = $this->_checkout->getQuoteId();
            $store = $this->_storeManager->getStore(true);
            $data['customerCartId'] = $quoteId;
            $data['url'] = $this->_settings->getRedirectUrl($quoteId, $store);
        }

        return $data;
    }
}