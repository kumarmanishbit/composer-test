<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Email\Event\Trigger;

class Wishlist extends SourceAbstract
{
    protected $_integration;
    protected $_customerRepo;
    protected $_productRepo;
    protected $_logger;

    /**
     * @param \Bronto\M2\Core\Log\LoggerInterface $logger
     * @param \Bronto\M2\Integration\CartSettingsInterface $integration
     * @param \Bronto\M2\Core\Customer\CacheInterface $customerRepo
     * @param \Bronto\M2\Core\Catalog\ProductCacheInterface $productRepo
     * @param \Bronto\M2\Email\SettingsInterface $settings
     * @param \Bronto\M2\Core\Directory\CurrencyManagerInterface $currencies
     * @param \Bronto\M2\Email\TriggerInterface $trigger
     * @param \Bronto\M2\Order\SettingsInterface $helper
     * @param \Bronto\M2\Core\Config\ScopedInterface $config
     * @param array $message
     */
    public function __construct(
        \Bronto\M2\Core\Log\LoggerInterface $logger,
        \Bronto\M2\Integration\CartSettingsInterface $integration,
        \Bronto\M2\Core\Customer\CacheInterface $customerRepo,
        \Bronto\M2\Core\Catalog\ProductCacheInterface $productRepo,
        \Bronto\M2\Email\SettingsInterface $settings,
        \Bronto\M2\Core\Directory\CurrencyManagerInterface $currencies,
        \Bronto\M2\Email\TriggerInterface $trigger,
        \Bronto\M2\Order\SettingsInterface $helper,
        \Bronto\M2\Core\Config\ScopedInterface $config,
        array $message
    ) {
        parent::__construct($settings, $currencies, $trigger, $helper, $config, $message);
        $this->_integration = $integration;
        $this->_customerRepo = $customerRepo;
        $this->_logger = $logger;
        $this->_productRepo = $productRepo;
    }

    /**
     * @see parent
     */
    public function transform($wishlist)
    {
        $customer = $this->_customerRepo->getById($wishlist->getCustomerId());
        $store = $customer->getStore();
        $delivery = $this->_createDelivery(
            $customer->getEmail(),
            $store,
            !isset($this->_message['previousMessage']) ?
                $this->_message['sendType'] :
            'triggered'
        );
        $index = 1;
        $fields = $this->_extraFields(['wishlist' => $wishlist]);
        $this->_setCurrency($store->getDefaultCurrencyCode());
        foreach ($wishlist->getItemCollection() as $item) {
            try {
                $product = $this->_productRepo->getById($item->getProductId(), $store->getId());
                $fields[] = $this->_createField("productId_{$index}", $product->getId());
                $fields[] = $this->_createField("productName_{$index}", $product->getName());
                $fields[] = $this->_createField("productSku_{$index}", $product->getSku());
                $fields[] = $this->_createField("productDescription_{$index}", $this->_productRepo->getDescription($product, $this->_helper->getDescriptionAttribute('store', $store)));
                $fields[] = $this->_createField("productUrl_{$index}", $item->getProductUrl());
                $fields[] = $this->_createField("productQty_{$index}", $item->getQty());
                $fields[] = $this->_createField("productPrice_{$index}", $this->_formatPrice($product->getPrice()));
                $fields[] = $this->_createField("productTotal_{$index}", $this->_formatPrice($product->getPrice() * $item->getQty()));
                $fields[] = $this->_createField("productImgUrl_{$index}", $this->_productRepo->getImage($product, $this->_helper->getImageAttribute('store', $store)));
            } catch (\Exception $e) {
                $this->_logger->critical($e);
            }
            $index++;
        }
        $fields[] = $this->_createField('quoteURL', $this->_integration->getRedirectUrl($wishlist->getId(), $store, 'wishlist'));
        $delivery['fields'] = $fields;
        return $delivery;
    }
}
