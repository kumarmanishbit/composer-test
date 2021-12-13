<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Email\Observer\Trigger;

abstract class ObserverAbstract implements \Magento\Framework\Event\ObserverInterface
{
    protected $_observer;

    /**
     * @param \Bronto\M2\Email\Trigger\Observer
     */
    public function __construct(
        \Bronto\M2\Email\Trigger\Observer $observer
    ) {
        $this->_observer = $observer;
    }
}
