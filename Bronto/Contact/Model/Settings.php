<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Contact\Model;

class Settings extends \Bronto\M2\Contact\SettingsAbstract
{
    /** @var \Magento\Customer\Model\ResourceModel\Attribute\CollectionFactory */
    protected $_attributeFactory;

    /** @var \Magento\Customer\Model\ResourceModel\Address\Attribute\CollectionFactory */
    protected $_addressFactory;

    /**
     * @param \Bronto\M2\Core\Store\ManagerInterface $storeManager
     * @param \Bronto\M2\Core\Customer\GroupCacheInterface $groupCache
     * @param \Bronto\M2\Core\Config\FactoryInterface $data
     * @param \Bronto\M2\Core\Config\ScopedInterface $config
     * @param \Bronto\M2\Core\Event\ManagerInterface $events
     * @param \Magento\Customer\Model\ResourceModel\Attribute\CollectionFactory $attributeFactory
     * @param \Magento\Customer\Model\ResourceModel\Address\Attribute\CollectionFactory $addressFactory
     */
    public function __construct(
        \Bronto\M2\Core\Store\ManagerInterface $storeManager,
        \Bronto\M2\Core\Customer\GroupCacheInterface $groupCache,
        \Bronto\M2\Core\Config\FactoryInterface $data,
        \Bronto\M2\Core\Config\ScopedInterface $config,
        \Bronto\M2\Core\Event\ManagerInterface $events,
        \Magento\Customer\Model\ResourceModel\Attribute\CollectionFactory $attributeFactory,
        \Magento\Customer\Model\ResourceModel\Address\Attribute\CollectionFactory $addressFactory
    ) {
        parent::__construct($storeManager, $groupCache, $data, $config, $events);
        $this->_attributeFactory = $attributeFactory;
        $this->_addressFactory = $addressFactory;
    }

    /**
     * @see parent
     */
    public function getAttributeLabels()
    {
        $attributes = [];
        $attributes[] = 'Attributes';
        $attributes[] = 'Shipping Address Attributes';
        $attributes[] = 'Billing Address Attributes';
        return array_combine(self::$_attributeKeys, $attributes);
    }

    /**
     * @see parent
     */
    public function getAttributes()
    {
        $addressAttributes = $this->_addressFactory->create();
        $attributes = [];
        $attributes[] = $this->_attributeFactory->create();
        $attributes[] = $addressAttributes;
        $attributes[] = $addressAttributes;
        return array_combine(self::$_attributeKeys, $attributes);
    }
}
