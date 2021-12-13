<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Order\Observer;

use Magento\Framework\Event\ObserverInterface;

class AfterTemplateFilterObserver extends ObserverAbstract
{
    /**
     * @see ObserverInterface::execute
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->_observer->eventFilter($observer);
    }
}
