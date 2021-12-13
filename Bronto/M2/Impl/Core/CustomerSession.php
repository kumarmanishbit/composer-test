<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Impl\Core;

class CustomerSession implements \Bronto\M2\Core\Customer\SessionInterface
{
    protected $_session;

    /**
     * @param \Magento\Customer\Model\Session $session
     */
    public function __construct(
        \Magento\Customer\Model\Session $session
    ) {
        $this->_session = $session;
    }

    /**
     * @see parent
     */
    public function logout()
    {
        $this->_session->logout();
        return $this;
    }

    /**
     * @see parent
     */
    public function getCustomer()
    {
        return $this->_session->getCustomer();
    }

    /**
     * @see parent
     */
    public function setBeforeAuthUrl($redirectUrl)
    {
        $this->_session->setBeforeAuthUrl($redirectUrl);
        return $this;
    }
}