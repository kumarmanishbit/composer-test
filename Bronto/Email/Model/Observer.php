<?php
/*
 * Copyright © 2021, 2022 Oracle and/or its affiliates.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Email\Model;

class Observer extends \Bronto\M2\Email\ExtensionAbstract
{
    protected $_emailConfig;
    protected $_emailTemplates;
    protected $_identities;
    protected $_groupRepo;
    protected $_searchBuilder;
    protected $_categoryManagement;

    /**
     * @param \Bronto\M2\Core\Sales\OrderStatusesInterface $statuses
     * @param \Magento\Email\Model\Template\Config $emailConfig
     * @param \Magento\Email\Model\ResourceModel\Template\CollectionFactory $emailTemplates
     * @param \Magento\Config\Model\Config\Source\Email\Identity $identities
     * @param \Magento\Customer\Api\GroupRepositoryInterface $groupRepo
     * @param \Magento\Catalog\Api\CategoryManagementInterface $categoryManagement
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchBuilder
     * @param \Bronto\M2\Email\TriggerManagerInterface $triggerManager
     * @param \Bronto\M2\Core\Store\ManagerInterface $storeManager
     * @param \Bronto\M2\Connector\QueueManagerInterface $queueManager
     * @param \Bronto\M2\Connector\SettingsInterface $connectorSettings
     * @param \Bronto\M2\Connector\Event\PlatformInterface $platform
     * @param \Bronto\M2\Email\Event\Source $source
     * @param \Bronto\M2\Email\SettingsInterface $helper
     * @param \Bronto\M2\Connector\MiddlewareInterface $middleware
     * @param \Bronto\M2\Core\Event\ManagerInterface $eventManager
     * @param \Bronto\M2\Core\App\EmulationInterface $appEmulation
     * @param \Bronto\M2\Helper\Data $mageHelper
     * @param \Magento\Framework\Filesystem\DriverInterface $fileSystemDriver
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Bronto\M2\Core\Sales\OrderStatusesInterface $statuses,
        \Magento\Email\Model\Template\Config $emailConfig,
        \Magento\Email\Model\ResourceModel\Template\CollectionFactory $emailTemplates,
        \Magento\Config\Model\Config\Source\Email\Identity $identities,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepo,
        \Magento\Catalog\Api\CategoryManagementInterface $categoryManagement,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchBuilder,
        \Bronto\M2\Email\TriggerManagerInterface $triggerManager,
        \Bronto\M2\Core\Store\ManagerInterface $storeManager,
        \Bronto\M2\Connector\QueueManagerInterface $queueManager,
        \Bronto\M2\Connector\SettingsInterface $connectorSettings,
        \Bronto\M2\Connector\Event\PlatformInterface $platform,
        \Bronto\M2\Email\Event\Source $source,
        \Bronto\M2\Email\SettingsInterface $helper,
        \Bronto\M2\Connector\MiddlewareInterface $middleware,
        \Bronto\M2\Core\Event\ManagerInterface $eventManager,
        \Bronto\M2\Core\App\EmulationInterface $appEmulation,
        \Bronto\M2\Helper\Data $mageHelper,
        \Magento\Framework\Filesystem\DriverInterface $fileSystemDriver,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct(
            $triggerManager,
            $statuses,
            $storeManager,
            $queueManager,
            $connectorSettings,
            $helper,
            $platform,
            $source,
            $middleware,
            $eventManager,
            $appEmulation,
            $mageHelper,
            $fileSystemDriver,
            $logger
        );
        $this->_emailConfig = $emailConfig;
        $this->_emailTemplates = $emailTemplates;
        $this->_identities = $identities;
        $this->_categoryManagement = $categoryManagement;
        $this->_groupRepo = $groupRepo;
        $this->_searchBuilder = $searchBuilder;
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
    protected function _defaultTemplates()
    {
        return $this->_emailConfig->getAvailableTemplates();
    }

    /**
     * @see parent
     */
    protected function _customTemplates()
    {
        return $this->_emailTemplates->create();
    }

    /**
     * @see paernt
     */
    protected function _emailIdentities()
    {
        $identities = [];
        foreach ($this->_identities->toOptionArray() as $option) {
            $identities[] = [
                'id' => $option['value'],
                'name' => $option['label']
            ];
        }
        return $identities;
    }

    /**
     * @see parent
     */
    protected function _targetAudience()
    {
        $groups = [];
        $list = $this->_groupRepo->getList($this->_searchBuilder->create());
        foreach ($list->getItems() as $group) {
            $groups[] = [
                'id' => $group->getId(),
                'name' => $group->getCode()
            ];
        }
        return $groups;
    }

    /**
     * @see parent
     */
    protected function _productCategories()
    {
        $root = $this->_categoryManagement->getTree(1);
        $options = [];
        $this->_flatCategories($options, $root->getChildrenData());
        return $options;
    }

    /**
     * Flattens the tree structure of the categories
     *
     * @param array &$$options
     * @param mixed $categories
     * @return void
     */
    protected function _flatCategories(&$options, $categories)
    {
        if ($categories) {
            foreach ($categories as $category) {
                $options[] = [
                    'id' => $category->getId(),
                    'name' => $category->getName()
                ];
                $this->_flatCategories($options, $category->getChildrenData());
            }
        }
    }
}
