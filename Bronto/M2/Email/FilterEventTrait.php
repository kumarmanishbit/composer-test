<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Email;

trait FilterEventTrait
{
    /**
     * Adds the event filter
     * 
     * @see FilterEventInterface::eventFilter
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function eventFilter(\Magento\Framework\Event\Observer $observer)
    {
        $observer->getFilter()->addEventFilter($this);
    }
}