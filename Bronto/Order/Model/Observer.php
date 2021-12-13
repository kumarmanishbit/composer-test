<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Order\Model;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\OrderRepositoryInterface;

class Observer extends \Bronto\M2\Order\ExtensionAbstract
{
    /** @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory */
    protected $_orderData;

    /**
     * @param \Bronto\M2\Core\Catalog\ProductAttributeCacheInterface $attributes
     * @param \Bronto\M2\Core\Sales\OrderStatusesInterface $statuses
     * @param \Bronto\M2\Core\Sales\OrderCacheInterface $orderRepo
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderData
     * @param \Bronto\M2\Core\App\EmulationInterface $appEmulation
     * @param \Bronto\M2\Core\Store\ManagerInterface $storeManager
     * @param \Bronto\M2\Connector\QueueManagerInterface $queueManager
     * @param \Bronto\M2\Connector\SettingsInterface $connectorSettings
     * @param \Bronto\M2\Connector\Event\PlatformInterface $platform
     * @param \Bronto\M2\Order\Event\Source $source
     * @param \Bronto\M2\Order\SettingsInterface $helper
     * @param \Bronto\M2\Helper\Data $mageHelper
     * @param SearchCriteriaBuilder $criteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param FilterGroupBuilder $filterGroupBuilder
     * @param OrderRepositoryInterface $orderRepository
     * @param \Magento\Framework\Filesystem\DriverInterface $fileSystemDriver
     * @param LoggerInterface $logger
     */
    public function __construct(
        \Bronto\M2\Core\Catalog\ProductAttributeCacheInterface $attributes,
        \Bronto\M2\Core\Sales\OrderStatusesInterface $statuses,
        \Bronto\M2\Core\Sales\OrderCacheInterface $orderRepo,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderData,
        \Bronto\M2\Core\App\EmulationInterface $appEmulation,
        \Bronto\M2\Core\Store\ManagerInterface $storeManager,
        \Bronto\M2\Connector\QueueManagerInterface $queueManager,
        \Bronto\M2\Connector\SettingsInterface $connectorSettings,
        \Bronto\M2\Connector\Event\PlatformInterface $platform,
        \Bronto\M2\Order\Event\Source $source,
        \Bronto\M2\Order\SettingsInterface $helper,
        \Bronto\M2\Helper\Data $mageHelper,
        SearchCriteriaBuilder $criteriaBuilder,
        FilterBuilder $filterBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        OrderRepositoryInterface $orderRepository,
        \Magento\Framework\Filesystem\DriverInterface $fileSystemDriver,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct(
            $attributes,
            $statuses,
            $orderRepo,
            $appEmulation,
            $storeManager,
            $queueManager,
            $connectorSettings,
            $helper,
            $platform,
            $source,
            $mageHelper,
            $criteriaBuilder,
            $filterBuilder,
            $filterGroupBuilder,
            $orderRepository,
            $fileSystemDriver,
            $logger
        );
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
     */
    protected function _collection()
    {
        return $this->_orderData->create();
    }
}
