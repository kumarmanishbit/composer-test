<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Optin;

class Checkout
{
    protected $_settings;
    protected $_subscribers;

    /**
     * @param \Bronto\M2\Optin\SettingsInterface $settings
     * @param \Bronto\M2\Core\Subscriber\ManagerInterface $subscribers
     */
    public function __construct(
        \Bronto\M2\Optin\SettingsInterface $settings,
        \Bronto\M2\Core\Subscriber\ManagerInterface $subscribers
    ) {
        $this->_settings = $settings;
        $this->_subscribers = $subscribers;
    }

    /**
     * Determines if the checkbox should be shown using basic logic
     *
     * @param mixed $storeId
     * @param mixed $customer
     * @param string $area
     * @return boolean
     */
    public function isCheckboxVisible($storeId, $customer = null, $area = null)
    {
        if (!$this->_settings->isCheckoutEnabled('store', $storeId)) {
            return false;
        }

        if (!is_null($customer)) {
            $subscriber = $this->_subscribers->getByEmail($customer->getEmail());
            if ($subscriber && $subscriber->getSubscriberStatus() == 1) {
                return false;
            }
        }

        if (is_null($area)) {
            return true;
        } else {
            $selectedArea = $this->_settings->getCheckoutLayout('store', $storeId);
            return $selectedArea == $area;
        }
    }

    /**
     * Determines if the checkbox on checkout is checked by default
     *
     * @param mixed $storeId
     * @return boolean
     */
    public function isCheckboxChecked($storeId)
    {
        return $this->_settings->isCheckedByDefault('store', $storeId);
    }
}
