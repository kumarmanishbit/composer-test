<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Contact\Model;

/**
 * @see https://github.com/magento/magento2/issues/3376
 */
class Customer extends \Magento\Customer\Model\Backend\Customer
{
    /**
     * @see parent
     */
    public function getStoreId()
    {
        return $this->getData('store_id');
    }
}