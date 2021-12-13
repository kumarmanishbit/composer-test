<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Model\ResourceModel\Tid;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Bronto\Connector\Model\ResourceModel\Tid
 */
class Collection extends AbstractCollection
{
    /**
     * Collection constructor.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(\Bronto\Connector\Model\Tid::class, \Bronto\Connector\Model\ResourceModel\Tid::class);
    }

    /**
     * @param int $cartId
     * @return self
     */
    public function addCartIdToFilter($cartId)
    {
        $this->addFieldToFilter('cart_id', $cartId);
        return $this;
    }

    /**
     * @param int $orderId
     * @return self
     */
    public function addOrderIdToFilter($orderId)
    {
        $this->addFieldToFilter('order_id', $orderId);
        return $this;
    }

    /**
     * @param array $orderIds
     * @return self
     */
    public function addOrderIdsToFilter(array $orderIds)
    {
        $this->addFieldToFilter('order_id', ['in' => $orderIds]);
        return $this;
    }
}