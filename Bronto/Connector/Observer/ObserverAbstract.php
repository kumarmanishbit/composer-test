<?php
/*
 * Copyright © 2021, 2022 Oracle and/or its affiliates.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Observer;

abstract class ObserverAbstract implements \Magento\Framework\Event\ObserverInterface
{
    protected $_observer;

    /**
     * @param \Bronto\Connector\Model\Observer
     */
    public function __construct(
        \Bronto\Connector\Model\Observer $observer
    ) {
        $this->_observer = $observer;
    }
}
