<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Product;

class Redirector implements \Bronto\M2\Connector\RedirectorInterface
{
    protected $_checkoutSession;
    protected $_storeManager;
    protected $_products;
    protected $_settings;
    protected $_logger;

    /**
     * @param \Bronto\M2\Core\Store\ManagerInterface $storeManager
     * @param \Bronto\M2\Core\Sales\CheckoutSessionInterface $checkoutSession
     * @param \Bronto\M2\Core\Catalog\ProductCacheInterface $products
     * @param \Bronto\M2\Product\SettingsInterface $settings
     * @param \Bronto\M2\Core\Log\LoggerInterface $logger
     */
    public function __construct(
        \Bronto\M2\Core\Store\ManagerInterface $storeManager,
        \Bronto\M2\Core\Sales\CheckoutSessionInterface $checkoutSession,
        \Bronto\M2\Core\Catalog\ProductCacheInterface $products,
        \Bronto\M2\Product\SettingsInterface $settings,
        \Bronto\M2\Core\Log\LoggerInterface $logger
    ) {
        $this->_storeManager = $storeManager;
        $this->_checkoutSession = $checkoutSession;
        $this->_settings = $settings;
        $this->_logger = $logger;
        $this->_products = $products;
    }

    /**
     * @see parent
     */
    public function redirectPath($observer)
    {
        $redirectUrl = '/';
        $request = $observer->getRequest();
        $productParam = $request->getParam('products', '');
        $store = $this->_storeManager->getStore(true);
        if ($this->_settings->isProductAddLink('store', $store)) {
            $cart = $this->_checkoutSession->getInitializedCart();
            $updated = false;
            foreach (explode(',', $productParam) as $productSku) {
                $product = $this->_products->getBySku($productSku, $store->getId());
                if ($product) {
                    try {
                        $result = $cart->addProduct($product);
                        if (is_string($result)) {
                            throw new \RuntimeException($result);
                        }
                        $updated = true;
                        $redirectUrl = 'checkout/cart';
                    } catch (\Exception $e) {
                        $this->_logger->critical($e);
                        $observer->getMessages()->addError($result);
                    }
                }
            }
            if ($updated) {
                $cart->save();
            }
        }
        $observer->getRedirect()->unsetParams(['products']);
        $observer->getRedirect()->setPath($store->getUrl($redirectUrl));
    }
}
