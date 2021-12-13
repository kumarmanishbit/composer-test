<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Email\Model;

class Settings extends \Bronto\M2\Email\SettingsAbstract
{
    const BRONTO_ID = 'BrontoEmailEnabled';
    const TEMPLATE = 'Magento\Framework\Mail\TemplateInterface';

    protected $_cartRepo;
    protected $_wishlistFactory;
    protected $_orderRepo;
    protected $_orderItemRepo;
    protected $_urlBuilder;
    protected $_objectManager;
    protected $_emailConfig;
    protected $_storeManager;
    protected $_filterFactory;

    /**
     * @param \Bronto\Email\Model\Context $context
     * @param \Bronto\M2\Connector\SettingsInterface $connectorSettings
     * @param \Bronto\Email\Model\Template\FilterFactory $filterFactory
     * @param \Bronto\M2\Core\Config\FactoryInterface $data
     * @param \Bronto\M2\Core\Config\ScopedInterface $config
     * @param \Bronto\M2\Core\Config\ManagerInterface $writer
     * @param \Bronto\M2\Core\App\EmulationInterface $appEmulation
     * @param \Bronto\M2\Core\Event\ManagerInterface $eventManager
     * @param \Bronto\M2\Core\Log\LoggerInterface $logger
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        Context $context,
        \Bronto\M2\Connector\SettingsInterface $connectorSettings,
        \Bronto\Email\Model\Template\FilterFactory $filterFactory,
        \Bronto\M2\Core\Config\FactoryInterface $configFactory,
        \Bronto\M2\Core\Config\ScopedInterface $scopedConfig,
        \Bronto\M2\Core\Config\ManagerInterface $configWriter,
        \Bronto\M2\Core\App\EmulationInterface $emulation,
        \Bronto\M2\Core\Store\ManagerInterface $storeManager,
        \Bronto\M2\Core\Event\ManagerInterface $events,
        \Bronto\M2\Core\Log\LoggerInterface $logger,
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        parent::__construct(
            $connectorSettings,
            $configFactory,
            $scopedConfig,
            $configWriter,
            $emulation,
            $storeManager,
            $events,
            $logger
        );
        $this->_filterFactory = $filterFactory;
        $this->_cartRepo = $context->getCartRepo();
        $this->_wishlistFactory = $context->getWishlistFactory();
        $this->_orderRepo = $context->getOrderRepo();
        $this->_orderItemRepo = $context->getOrderItemRepo();
        $this->_urlBuilder = $context->getUrlBuilder();
        $this->_emailConfig = $context->getEmailConfig();
        $this->_storeManager = $context->getStoreManager();
        $this->_objectManager = $objectManager;
    }

    /**
     * @see parent
     */
    public function getModelTuple($model)
    {
        $modelType = 'template';
        if ($model instanceof \Magento\Sales\Model\Order) {
            $modelType = 'order';
        } elseif ($model instanceof \Magento\Quote\Model\Quote) {
            $modelType = 'cart';
        } elseif ($model instanceof \Magento\Wishlist\Model\Wishlist) {
            $modelType = 'wishlist';
        } elseif ($model instanceof \Magento\Sales\Model\Order\Item) {
            $modelType = 'order_item';
        }
        return [$modelType, $model->getId()];
    }

    /**
     * @see parent
     */
    public function getTriggerModel(\Bronto\M2\Email\TriggerInterface $trigger)
    {
        return $this->loadModel($trigger->getModelType(), $trigger->getModelId());
    }

    /**
     * @see parent
     */
    public function loadModel($modelType, $modelId)
    {
        try {
            switch ($modelType) {
                case 'order':
                    return $this->_orderRepo->get($modelId);
                case 'order_item':
                    $orderItem = $this->_orderItemRepo->create();
                    if ($orderItem->load($modelId)->getId()) {
                        return $orderItem;
                    }
                    return null;
                case 'wishlist':
                    $wishlist = $this->_wishlistFactory->create();
                    if ($wishlist->load($modelId)->getId()) {
                        return $wishlist;
                    }
                    return null;
                case 'cart':
                    return $this->_cartRepo->get($modelId);
            }
        } catch (\Magento\Framework\Exception\NoSuchEntityException $Nse) {
            $this->_logger->critical($Nse->getMessage());
        }
        return null;
    }

    /**
     * @see parent
     */
    public function getTemplateFilter()
    {
        return $this->_filterFactory->create()
            ->setUseAbsoluteLinks(true)
            ->setUrlModel($this->_urlBuilder)
            ->setPlainTemplateMode(false);
    }


    /**
     * @see parent
     */
    public function isBrontoMessage($message)
    {
        return preg_match('/^' . self::BRONTO_ID . '/', $message->getSubject());
    }

    /**
     * @see parent
     */
    public function getStoreId($message)
    {
        list($tag, $storeId) = explode(':', $message->getSubject());
        return $storeId;
    }

    /**
     * @see parent
     */
    public function getTemplate($templateId, $options = [])
    {
        $template = $this->_objectManager->create(self::TEMPLATE);
        if (is_numeric($templateId)) {
            $template->load($templateId);
            if (!isset($options['area'])) {
                $options['area'] = $this->_emailConfig->getTemplateArea($template->getOrigTemplateCode());
            }
            $template->setDesignConfig($options);
        } else {
            if (!isset($options['area'])) {
                $options['area'] = $this->_emailConfig->getTemplateArea($templateId);
            }
            if (!isset($options['store'])) {
                $options['store'] = $this->_storeManager->getStore()->getId();
            }
            $template
                ->setDesignConfig($options)
                ->loadDefault($templateId);
            $template->setTemplateCode($this->_emailConfig->getTemplateLabel($templateId));
        }
        return $template;
    }

    /**
     * @see parent
     */
    protected function _applyFilterFunctions($template, $filter)
    {
        return $filter
            ->setIsChildTemplate($template->isChildTemplate())
            ->setTemplateProcessor([$template, 'getTemplateContent']);
    }
}
