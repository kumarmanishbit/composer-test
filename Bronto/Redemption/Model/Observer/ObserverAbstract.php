<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Redemption\Model\Observer;

abstract class ObserverAbstract implements \Magento\Framework\Event\ObserverInterface
{
    protected $_observer;

    /**
     * @param \Bronto\Redemption\Model\Observer $observer
     */
    public function __construct(
        \Bronto\Redemption\Model\Observer $observer
    ) {
        $this->_observer = $observer;
    }
}
