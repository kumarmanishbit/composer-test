<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Cart\Block;

class Capture extends \Magento\Framework\View\Element\Template
{
    protected $_settings;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Bronto\M2\Cart\SettingsInterface $settings
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Bronto\M2\Cart\SettingsInterface $settings,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_settings = $settings;
    }

    /**
     * Determines if any cart capturing is enabled
     *
     * @return boolean
     */
    public function isCartRecoveryEnabled()
    {
        return $this->_settings->isCartRecoveryEnabled('store', $this->_storeManager->getStore(true));
    }

    /**
     * Gets the CSS selectors
     *
     * @return string
     */
    public function getCartRecoverySelectors()
    {
        return $this->_settings->getCartRecoverySelectors('store', $this->_storeManager->getStore(true));
    }

    /**
     * Gets the capture endpoint for the store's frontend
     *
     * @return string
     */
    public function getCaptureUrl()
    {
        $currentStore = $this->_storeManager->getStore(true);
        return $this->getUrl('bcart/cart/capture', [
            '_secure' => $currentStore->isCurrentlySecure()
        ]);
    }
}
