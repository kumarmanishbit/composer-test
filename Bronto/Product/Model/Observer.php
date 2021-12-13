<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Product\Model;

class Observer extends \Bronto\M2\Product\ExtensionAbstract
{
    /** @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory */
    protected $_productsFactory;

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productsFactory
     * @param \Bronto\M2\Core\Catalog\ProductAttributeCacheInterface $attributes
     * @param \Bronto\M2\Connector\MiddlewareInterface $middleware
     * @param \Bronto\M2\Connector\RegistrationManagerInterface $registrations
     * @param \Bronto\M2\Core\Catalog\ProductCacheInterface $productRepo
     * @param \Bronto\M2\Core\App\EmulationInterface $appEmulation
     * @param \Bronto\M2\Core\Store\ManagerInterface $storeManager
     * @param \Bronto\M2\Connector\QueueManagerInterface $queueManager
     * @param \Bronto\M2\Connector\SettingsInterface $connectorSettings
     * @param \Bronto\M2\Connector\Event\HelperInterface $helper
     * @param \Bronto\M2\Connector\Event\PlatformInterface $platform
     * @param \Bronto\M2\Product\Event\Source $source
     * @param \Magento\Framework\Filesystem\DriverInterface $fileSystemDriver
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productsFactory,
        \Bronto\M2\Core\Catalog\ProductAttributeCacheInterface $attributes,
        \Bronto\M2\Connector\MiddlewareInterface $middleware,
        \Bronto\M2\Connector\RegistrationManagerInterface $registrations,
        \Bronto\M2\Core\Catalog\ProductCacheInterface $productRepo,
        \Bronto\M2\Core\App\EmulationInterface $appEmulation,
        \Bronto\M2\Core\Store\ManagerInterface $storeManager,
        \Bronto\M2\Connector\QueueManagerInterface $queueManager,
        \Bronto\M2\Connector\SettingsInterface $connectorSettings,
        \Bronto\M2\Product\SettingsInterface $helper,
        \Bronto\M2\Connector\Event\PlatformInterface $platform,
        \Bronto\M2\Product\Event\Source $source,
        \Magento\Framework\Filesystem\DriverInterface $fileSystemDriver,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct(
            $attributes,
            $middleware,
            $registrations,
            $productRepo,
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
        $this->_productsFactory = $productsFactory;
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
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    protected function _collection()
    {
        return $this->_productsFactory->create();
    }
}
