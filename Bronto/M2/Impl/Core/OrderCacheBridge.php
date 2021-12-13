<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Impl\Core;

class OrderCacheBridge implements \Bronto\M2\Core\Sales\OrderCacheInterface
{
    protected $_orderRepo;

    /**
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepo
     */
    public function __construct(
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepo
    ) {
        $this->_orderRepo = $orderRepo;
    }

    /**
     * @see \Bronto\M2\Core\Sales\OrderCacheInterface::getById
     * @param int $orderId The order ID.
     * @return \Magento\Sales\Api\Data\OrderInterface|null
     */
    public function getById($orderId)
    {
        try {
            return $this->_orderRepo->get($orderId);
        } catch (\Exception $e) {
            return null;
        }
    }
}
