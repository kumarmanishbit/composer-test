<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Browse;

class Settings extends \Bronto\M2\Core\Config\ContainerAbstract implements \Bronto\M2\Browse\SettingsInterface
{
    const BRONTO_BROWSE = '__bmbc_br';

    protected $_cookies;
    protected $_writer;
    protected $_integration;
    protected $_session;
    protected $_productRepo;

    /** @var \Bronto\M2\Core\Store\ManagerInterface */
    protected $storeManager;

    /**
     * @param \Bronto\M2\Core\Cookie\WriterInterface $writer
     * @param \Bronto\M2\Core\Cookie\ReaderInterface $cookies
     * @param \Bronto\M2\Integration\SettingsInterface $integration
     * @param \Bronto\M2\Core\Customer\SessionInterface $session
     * @param \Bronto\M2\Core\Config\ScopedInterface $config
     * @param \Bronto\M2\Core\Catalog\ProductCacheInterface $productRepo
     */
    public function __construct(
        \Bronto\M2\Core\Cookie\WriterInterface $writer,
        \Bronto\M2\Core\Cookie\ReaderInterface $cookies,
        \Bronto\M2\Integration\SettingsInterface $integration,
        \Bronto\M2\Core\Customer\SessionInterface $session,
        \Bronto\M2\Core\Config\ScopedInterface $config,
        \Bronto\M2\Core\Catalog\ProductCacheInterface $productRepo,
        \Bronto\M2\Core\Store\ManagerInterface $storeManager
    ) {
        parent::__construct($config);
        $this->_writer = $writer;
        $this->_cookies = $cookies;
        $this->_integration = $integration;
        $this->_session = $session;
        $this->_productRepo = $productRepo;
        $this->storeManager = $storeManager;
    }

    /**
     * @see parent
     */
    public function isEnabled($scope = 'default', $scopeId = null)
    {
        return $this->_config->isSetFlag(self::XML_PATH_ENABLED, $scope, $scopeId);
    }

    /**
     * @see parent
     */
    public function isSearchEnabled($scope = 'default', $scopeId = null)
    {
        return $this->_config->isSetFlag(self::XML_PATH_SEARCH_ENABLED, $scope, $scopeId);
    }

    /**
     * @see parent
     */
    public function getUniqueCustomerId()
    {
        $guid = $this->_cookies->getCookie(self::BRONTO_BROWSE, '');
        if (empty($guid)) {
            $guid = $this->_integration->generateUUID();
            $this->_writer->setServerCookie(self::BRONTO_BROWSE, $guid);
        }
        return $guid;
    }

    /**
     * @see \Bronto\M2\Browse\SettingsInterface::getCustomerEmail
     * @return string|null
     */
    public function getCustomerEmail()
    {
        $email = $this->_session->getCustomer()->getEmail();
        if (!$email) {
            $quote = new \Bronto\M2\Core\DataObject([
                'customer_email' => false,
                'store_id' => $this->storeManager->getStore(true)->getId()
            ]);
            $email = $this->_integration->getCartRecoveryEmail($quote);
        }

        return $email;
    }

    /**
     * @see parent
     */
    public function getSiteId($scope = 'default', $scopeId = null)
    {
        return $this->_config->getValue(self::XML_PATH_SITE, $scope, $scopeId);
    }

    /**
     * @see parent
     */
    public function createContext($browse, $when = null)
    {
        if (is_null($when)) {
            $when = time();
        }
        $context = [
            'customer_id' => $this->getUniqueCustomerId(),
            'store_id' => $browse->getStoreId(),
            'timestamp' => $when
        ];
        if ($browse->hasProduct()) {
            $context['product_id'] = $browse->getProduct()->getId();
            $context['category_id'] = $browse->getProduct()->getCategoryId();
            $context['value'] = $browse->getProduct()->getSku();
            $context['url'] = $this->_productRepo->getUrl($browse->getProduct());
        }
        if ($browse->hasUrl()) {
            $context['url'] = $browse->getUrl();
        }
        if ($browse->hasEventType()) {
            $context['event_type'] = $browse->getEventType();
        }
        if ($browse->hasEventTypeValue()) {
            $context['event_type_value'] = $browse->getEventTypeValue();
        }
        $email = $this->getCustomerEmail();
        if ($email) {
            $context['customer_email'] = $email;
        }

        return $context;
    }
}
