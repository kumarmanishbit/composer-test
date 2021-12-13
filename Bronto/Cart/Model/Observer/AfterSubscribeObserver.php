<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Cart\Model\Observer;

/**
 * Class AfterSubscribeObserver
 * @package Bronto\Cart\Model\Observer
 */
class AfterSubscribeObserver extends AfterBrontoSiteFiddleObserver
{
    /**
     * Queue up event changes and dispatch the cart fiddle event.
     * 
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->_observer->pushChanges($observer);
        
        if ($this->_isEnabled()) {
            $this->_eventManager->dispatch(self::CART_FIDDLE, [
                'quote' => $this->_checkout->getQuote()->setUpdatedAt(date('c'))
            ]);
        }
    }
}
