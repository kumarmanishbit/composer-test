<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Product\Model\Observer;

use Bronto\M2\Core\DataObject;

class AfterCatalogProductSaveObserver extends ObserverAbstract
{
    /**
     * @see parent
     */
    public function execute(\Magento\Framework\Event\Observer $event)
    {
        $event = new DataObject($event->getData());
        $this->_observer->pushChangesToAll($event);
    }
}
