<?php
/*
 * Copyright © 2021, 2022 Oracle and/or its affiliates.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Contact\Model;

class Observer extends \Bronto\M2\Contact\ExtensionAbstract
{
    /** @var \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory  */
    protected $_customerData;

    /** @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory */
    protected $_orderData;

    /**
     * @param \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerData
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderData
     * @param \Bronto\M2\Core\Sales\OrderCacheInterface $orderRepo
     * @param \Bronto\M2\Core\Customer\CacheInterface $customerRepo
     * @param \Bronto\M2\Core\App\EmulationInterface $appEmulation
     * @param \Bronto\M2\Core\Store\ManagerInterface $storeManager
     * @param \Bronto\M2\Connector\QueueManagerInterface $queueManager
     * @param \Bronto\M2\Connector\SettingsInterface $connectorSettings
     * @param \Bronto\M2\Connector\Event\PlatformInterface $platform
     * @param \Bronto\M2\Contact\Event\Source $source
     * @param \Bronto\M2\Contact\SettingsInterface $helper
     * @param \Magento\Framework\Filesystem\DriverInterface $fileSystemDriver
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerData,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderData,
        \Bronto\M2\Core\Sales\OrderCacheInterface $orderRepo,
        \Bronto\M2\Core\Customer\CacheInterface $customerRepo,
        \Bronto\M2\Core\App\EmulationInterface $appEmulation,
        \Bronto\M2\Core\Store\ManagerInterface $storeManager,
        \Bronto\M2\Connector\QueueManagerInterface $queueManager,
        \Bronto\M2\Connector\SettingsInterface $connectorSettings,
        \Bronto\M2\Connector\Event\PlatformInterface $platform,
        \Bronto\M2\Contact\Event\Source $source,
        \Bronto\M2\Contact\SettingsInterface $helper,
        \Magento\Framework\Filesystem\DriverInterface $fileSystemDriver,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct(
            $orderRepo,
            $customerRepo,
            $appEmulation,
            $storeManager,
            $queueManager,
            $connectorSettings,
            $helper,
            $platform,
            $source,
            $fileSystemDriver,
            $logger
        );
        $this->_customerData = $customerData;
        $this->_orderData = $orderData;
    }

    /**
     * @see parent
     */
    public function translate($message)
    {
        return __($message);
    }

    /**
     * @see parent
     * @return \Magento\Customer\Model\ResourceModel\Customer\Collection
     */
    protected function _contactCollection()
    {
       // $this->_customerData->create() to create the model object.
        return $this->_customerData->create();
    }

    /**
     * @see parent
     * @return \Magento\Sales\Model\ResourceModel\Order\Collection
     */
    protected function _orderCollection()
    {
        return $this->_orderData->create();
    }
}
