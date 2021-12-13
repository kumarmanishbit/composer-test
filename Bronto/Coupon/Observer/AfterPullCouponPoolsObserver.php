<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Coupon\Observer;

class AfterPullCouponPoolsObserver extends ObserverAbstract
{
    /**
     * @see parent
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->_observer->pullCouponPools($observer);
    }
}
