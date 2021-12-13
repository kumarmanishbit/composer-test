<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Contact\Observer;

class AfterAccountEditedObserver extends ObserverAbstract
{
    protected $_session;

    /**
     * @param \Bronto\Contact\Model\Observer
     * @param \Magento\Customer\Model\Session $session
     */
    public function __construct(
        \Bronto\Contact\Model\Observer $observer,
        \Magento\Customer\Model\Session $session
    ) {
        parent::__construct($observer);
        $this->_session = $session;
    }

    /**
     * @see parent
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->_observer->updateEmail(
            $this->_session->getCustomerId(),
            $observer->getRequest()->getParam('email')
        );
    }
}
