<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Model;

use Bronto\Connector\Api\Data\TidInterface;
use Bronto\Transfer\Exception;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Tid
 * 
 * @package Bronto\Connector\Model
 */
class Tid extends AbstractExtensibleModel implements TidInterface
{
    const KEY_ID = 'id';
    const KEY_VALUE = 'value';
    const KEY_CART_ID = 'cart_id';
    const KEY_ORDER_ID = 'order_id';
    const KEY_CREATED_AT = 'created_at';

    /**
     * Constructor
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init(\Bronto\Connector\Model\ResourceModel\Tid::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData(self::KEY_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->setData(self::KEY_ID, $id);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->getData(self::KEY_VALUE);
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        if (!ctype_digit($value)) {
            throw new \DomainException('String must consist of only digits');
        }
        $this->setData(self::KEY_VALUE, $value);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCartId()
    {
        return $this->getData(self::KEY_CART_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setCartId($id)
    {
        $this->setData(self::KEY_CART_ID, $id);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderId()
    {
        return $this->getData(self::KEY_ORDER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setOrderId($id)
    {
        $this->setData(self::KEY_ORDER_ID, $id);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->getData(self::KEY_CREATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($time)
    {
        $this->setData(self::KEY_CREATED_AT, $time);
        return $this;
    }
}