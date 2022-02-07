<?php
/*
 * Copyright © 2021, 2022 Oracle and/or its affiliates.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Coupon\Observer;

abstract class ObserverAbstract implements \Magento\Framework\Event\ObserverInterface
{
    protected $_observer;

    /**
     * @param \Bronto\Coupon\Model\Observer
     */
    public function __construct(
        \Bronto\Coupon\Model\Observer $observer
    ) {
        $this->_observer = $observer;
    }
}
