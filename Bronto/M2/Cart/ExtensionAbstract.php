<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Cart;

abstract class ExtensionAbstract extends \Bronto\M2\Connector\Discovery\ExtensionPushEventAbstract implements \Bronto\M2\Connector\Discovery\TransformEventInterface
{
    /** @var \Bronto\M2\Core\Sales\QuoteManagementInterface */
    protected $_quoteRepo;

    /**
     * @param \Bronto\M2\Core\Sales\QuoteManagementInterface $quoteRepo
     * @param \Bronto\M2\Core\Store\ManagerInterface $storeManager
     * @param \Bronto\M2\Connector\QueueManagerInterface $queueManager
     * @param \Bronto\M2\Connector\SettingsInterface $connectorSettings
     * @param \Bronto\M2\Connector\Event\HelperInterface $helper
     * @param \Bronto\M2\Connector\Event\PlatformInterface $platform
     * @param \Bronto\M2\Connector\Event\SourceInterface $source
     */
    public function __construct(
        \Bronto\M2\Core\Sales\QuoteManagementInterface $quoteRepo,
        \Bronto\M2\Core\Store\ManagerInterface $storeManager,
        \Bronto\M2\Connector\QueueManagerInterface $queueManager,
        \Bronto\M2\Connector\SettingsInterface $connectorSettings,
        \Bronto\M2\Cart\SettingsInterface $helper,
        \Bronto\M2\Connector\Event\PlatformInterface $platform,
        \Bronto\M2\Connector\Event\SourceInterface $source
    ) {
        parent::__construct(
            $storeManager,
            $queueManager,
            $connectorSettings,
            $helper,
            $platform,
            $source
        );
        $this->_quoteRepo = $quoteRepo;
    }

    /**
     * @see parent
     */
    public function transformEvent($observer)
    {
        $data = [];
        $transform = $observer->getTransform();
        $event = $transform->getContext();
        $quote = $this->_quoteRepo->getById($event['id']);
        if (empty($quote)) {
            $quote = new \Bronto\M2\Core\DataObject(
                [
                    'id' => $event['id'],
                    'items_count' => 0
                ]
            );
            $quote->setStore($this->_storeManager->getStore($event['storeId']));
            $quote->isDeleted(true);
        } else {
            $quote = clone $quote;
            $quote->isDeleted($event['is_deleted']);
        }
        $quote->isObjectNew($event['is_new']);
        if (array_key_exists('emailAddress', $event)) {
            $quote->setCustomerEmail($event['emailAddress']);
        }
        if (array_key_exists('redirect_url', $event)) {
            $quote->setRedirectUrl($event['redirect_url']);
        }
        $data = $this->_source->transform($quote);
        $transform->setCart($data);
    }

    /**
     * Adds an API dropdown to the integration extension
     *
     * @param mixed $observer
     * @return void
     */
    public function integrationAdditional($observer)
    {
        $observer->getEndpoint()->addFieldToExtension('cart_recovery', [
            'id' => 'selectors',
            'name' => 'Email CSS Selectors',
            'type' => 'text',
            'required' => true,
            'typeProperties' => [ 'default' => $this->_emailSelector() ]
        ]);

        $observer->getEndpoint()->addFieldToExtension(
            'cart_recovery',
            [
                'id' => 'tax_included',
                'name' => 'Include Tax with Price',
                'type' => 'boolean',
                'required' => true,
                'typeProperties' => ['default' => false]
            ]
        );
    }

    /**
     * @see parent
     */
    protected function _getObject($observer)
    {
        return $observer->getQuote();
    }

    /**
     * Default email selector for the platform
     *
     * @return string
     */
    protected function _emailSelector()
    {
        return '.validate-email';
    }
}
