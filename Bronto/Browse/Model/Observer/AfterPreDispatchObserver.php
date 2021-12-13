<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Browse\Model\Observer;

class AfterPreDispatchObserver implements \Magento\Framework\Event\ObserverInterface
{
    protected $_settings;

    /**
     * @param \Bronto\M2\Browse\SettingsInterface $settings
     */
    public function __construct(
        \Bronto\M2\Browse\SettingsInterface $settings
    ) {
        $this->_settings = $settings;
    }

    /**
     * @see parent
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->_settings->getUniqueCustomerId();
    }
}
