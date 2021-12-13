<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Core\Sales;

interface OrderCacheInterface
{
    /**
     * Gets an order by its unique id
     *
     * @param int $orderId
     * @return \Magento\Sales\Api\Data\OrderInterface|null
     */
    public function getById($orderId);
}
