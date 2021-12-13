<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Email\Event\Trigger;

class Reorder extends OrderBasedAbstract
{
    protected $_stockManager;

    /**
     * @param \Bronto\M2\Core\Stock\ManagerInterface $stockManager
     * @param \Bronto\M2\Email\SettingsInterface $settings
     * @param \Bronto\M2\Core\Directory\CurrencyManagerInterface $currencies
     * @param \Bronto\M2\Email\TriggerInterface $trigger
     * @param \Bronto\M2\Order\SettingsInterface $helper
     * @param \Bronto\M2\Core\Config\ScopedInterface $config
     * @param \Bronto\M2\Core\Sales\AddressRenderInterface $addressRender
     * @param array $message
     */
    public function __construct(
        \Bronto\M2\Core\Stock\ManagerInterface $stockManager,
        \Bronto\M2\Email\SettingsInterface $settings,
        \Bronto\M2\Core\Directory\CurrencyManagerInterface $currencies,
        \Bronto\M2\Email\TriggerInterface $trigger,
        \Bronto\M2\Order\SettingsInterface $helper,
        \Bronto\M2\Core\Config\ScopedInterface $config,
        \Bronto\M2\Core\Sales\AddressRenderInterface $addressRender,
        array $message
    ) {
        parent::__construct(
            $settings,
            $currencies,
            $trigger,
            $helper,
            $config,
            $addressRender,
            $message
        );
        $this->_stockManager = $stockManager;
    }

    /**
     * @see parent
     */
    public function action($lineItem)
    {
        $stock = $this->_stockManager->getByProductId($lineItem->getProductId(), $lineItem->getStoreId());
        if (empty($stock) || !$stock->getIsInStock()) {
            return '';
        }
        return 'add';
    }

    /**
     * @see parent
     */
    public function transform($lineItem)
    {
        $order = $lineItem->getOrder();
        $store = $order->getStore();
        $inclTax = (int)$this->_config->getValue(self::XML_PATH_PRICE_DISPLAY, 'store', $store);
        $delivery = $this->_createDelivery($order->getCustomerEmail(), $store);
        $fields = array_merge(
            $this->_createOrderFields($order, $store),
            $this->_createLineItemFields($lineItem, $inclTax),
            $this->_extraFields(['order' => $order])
        );
        $delivery['fields'] = $fields;
        return $delivery;
    }
}
