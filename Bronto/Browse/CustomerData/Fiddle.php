<?php
/*
 * Copyright © 2021, 2022 Oracle and/or its affiliates.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Browse\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Bronto\M2\Integration\ScriptManagerSettings;
use Bronto\M2\Integration\ScriptManagerSettingsInterface;

class Fiddle extends \Magento\Framework\View\Element\Template implements SectionSourceInterface
{
    /** @var \Bronto\M2\Browse\SettingsInterface */
    protected $settings;
    
    /** @var \Magento\Framework\Registry */
    protected $registry;
    
    /** @var \Magento\Store\Model\StoreManagerInterface */
    protected $storeManager;

    /** @var ScriptManagerSettingsInterface $scriptManagerSettings */
    protected $scriptManagerSettings;

    /**
     * @param \Bronto\M2\Browse\SettingsInterface $settings
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Bronto\M2\Browse\SettingsInterface $settings,
        \Bronto\M2\Integration\ScriptManagerSettingsInterface $scriptManagerSettings,
        array $data = []
    ) {
    
        parent::__construct($context, $data);
        $this->settings = $settings;
        $this->scriptManagerSettings = $scriptManagerSettings;
        $this->registry = $registry;
        $this->storeManager = $context->getStoreManager();
    }

    /**
     * @see SectionSourceInterface::getSectionData
     * @return array
     */
    public function getSectionData()
    {
        $data = [];
        if ($this->settings->isEnabled('store', $this->storeManager->getStore()->getId())) {
            $data['customerId'] = $this->settings->getUniqueCustomerId();
            $data['emailAddress'] = $this->settings->getCustomerEmail();
            
            $storeId = $this->storeManager->getStore(true)->getId();
            $data['browseSiteId'] = $this->settings->getSiteId('store', $storeId);
        }
        return $data;
    }
    
    /**
     * Returns the ID of the current product
     *
     * @return string ID of the current product
     */
    public function getCurrentProductId()
    {
        $currentProduct = $this->registry->registry('product');
        return ($currentProduct !== null)? $currentProduct->getSKU() : null;
    }

    /**
     * @return bool
     */
    public function canRenderProductId()
    {
        $storeId = $this->storeManager->getStore(true)->getId();
        return $this->settings->isEnabled('store', $storeId) 
            || $this->scriptManagerSettings->isEnabled('store', $storeId);
    }
}
