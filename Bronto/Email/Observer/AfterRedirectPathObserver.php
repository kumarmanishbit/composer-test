<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Email\Observer;

class AfterRedirectPathObserver implements \Magento\Framework\Event\ObserverInterface
{
    protected $_redirect;

    /**
     * @param \Bronto\M2\Email\Redirector $redirect
     */
    public function __construct(\Bronto\M2\Email\Redirector $redirect)
    {
        $this->_redirect = $redirect;
    }

    /**
     * @see parent
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->_redirect->redirectPath($observer);
    }
}
