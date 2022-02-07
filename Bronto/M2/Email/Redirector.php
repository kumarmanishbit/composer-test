<?php
/*
 * Copyright © 2021, 2022 Oracle and/or its affiliates.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Email;

class Redirector implements \Bronto\M2\Connector\RedirectorInterface
{
    protected $_customerSession;
    protected $_quoteManagement;
    protected $_checkoutSession;
    protected $_storeManager;
    protected $_encrypt;
    protected $_helper;
    protected $_logger;

    /**
     * @param \Bronto\M2\Core\Store\ManagerInterface $storeManager
     * @param \Bronto\M2\Core\Customer\SessionInterface $customerSession
     * @param \Bronto\M2\Core\Sales\QuoteManagementInterface $quoteManagement
     * @param \Bronto\M2\Core\Sales\CheckoutSessionInterface $checkoutSession
     * @param \Bronto\M2\Core\EncryptorInterface $encrypt
     * @param \Bronto\M2\Email\SettingsInterface $helper
     * @param \Bronto\M2\Core\Log\LoggerInterface $logger
     */
    public function __construct(
        \Bronto\M2\Core\Store\ManagerInterface $storeManager,
        \Bronto\M2\Core\Customer\SessionInterface $customerSession,
        \Bronto\M2\Core\Sales\QuoteManagementInterface $quoteManagement,
        \Bronto\M2\Core\Sales\CheckoutSessionInterface $checkoutSession,
        \Bronto\M2\Core\EncryptorInterface $encrypt,
        \Bronto\M2\Email\SettingsInterface $helper,
        \Bronto\M2\Core\Log\LoggerInterface $logger
    ) {
        $this->_storeManager = $storeManager;
        $this->_customerSession = $customerSession;
        $this->_quoteManagement = $quoteManagement;
        $this->_checkoutSession = $checkoutSession;
        $this->_encrypt = $encrypt;
        $this->_helper = $helper;
        $this->_logger = $logger;
    }

    /**
     * @see parent
     */
    public function redirectPath($observer)
    {
        $request = $observer->getRequest();
        $modelId = $request->getParam('id', false);
        $modelType = $request->getParam('type', false);
        $store = $this->_storeManager->getStore(true);
        $redirectUrl = $store->getUrl('checkout/cart');
        if ($modelId && $modelType) {
            $modelId = $this->_encrypt->decrypt(base64_decode(urldecode($modelId)));
            $model = $this->_helper->loadModel($modelType, $modelId);
            if ($model) {
                $customerId = $this->_customerSession->getCustomer()->getId();
                $forceLogin = false;
                switch ($modelType) {
                    case 'wishlist':
                        $store = $model->getStore();
                        $redirectUrl = $store->getUrl('wishlist');
                        $forceLogin = $customerId != $model->getCustomerId();
                        break;
                    default:
                        $store = $this->_storeManager->getStore($model->getStoreId());
                        if ($model->getIsActive()) {
                            $redirectUrl = $store->getUrl('checkout/cart');
                            $this->_checkoutSession->resetCheckout();
                            if ($customerId && $model->getCustomerGroupId() == 0) {
                                if ($this->_checkoutSession->getQuoteId()) {
                                    $cart = $this->_checkoutSession->getInitializedCart();
                                    $sessionCart = $cart->getQuote();
                                    if ($model->getId() != $sessionCart->getId()) {
                                        $sessionCart->merge($model);
                                        $cart->save();
                                    }
                                } else {
                                    try {
                                        $this->_quoteManagement->assignCustomer($model->getId(), $customerId, $store->getId());
                                    } catch (\Exception $e) {
                                        $this->_logger->critical($e);
                                    }
                                }
                            } elseif ($customerId && $model->getCustomerId() && $model->getCustomerId() != $customerId) {
                                $this->_customerSession->logout();
                                $forceLogin = true;
                            } elseif ($model->getCustomerGroupId() == 0 && !$customerId) {
                                $cart = $this->_checkoutSession->getInitializedCart();
                                $sessionCart = $cart->getQuote();
                                if ($model->getId() != $sessionCart->getId()) {
                                    $sessionCart->merge($model);
                                    $cart->save();
                                }
                            } elseif ($model->getCustomerId() && !$customerId) {
                                $forceLogin = true;
                            }
                        }
                }
                if ($forceLogin) {
                    $this->_customerSession->setBeforeAuthUrl($redirectUrl);
                    $redirectUrl = $store->getUrl('customer/account/login');
                }
            }
        }
        $observer->getRedirect()->unsetParams(['type', 'id']);
        $observer->getRedirect()->setPath($redirectUrl);
    }
}
