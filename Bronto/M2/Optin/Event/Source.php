<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Optin\Event;

class Source implements \Bronto\M2\Connector\Event\SourceInterface, \Bronto\M2\Connector\Event\ContextProviderInterface
{
    private $_helper;

    /**
     * @param \Bronto\M2\Optin\SettingsInterface $helper
     */
    public function __construct(
        \Bronto\M2\Optin\SettingsInterface $helper
    ) {
        $this->_helper = $helper;
    }

    /**
     * @see parent
     */
    public function create($subscriber)
    {
        return [
            'location' => $subscriber->getLocation(),
            'ignore_status' => $subscriber->getIgnoreStatus(),
            'uniqueKey' => implode('.', [
                'optin',
                $this->_brontoStatus($subscriber),
                $subscriber->getId()
            ])
        ];
    }

    /**
     * @see parent
     */
    public function getEventType()
    {
        return 'subscriber';
    }

    /**
     * @see parent
     */
    public function action($subscriber)
    {
        return 'replace';
    }

    /**
     * @see parent
     */
    public function transform($subscriber)
    {
        $status = null;
        if (!$subscriber->getIgnoreStatus()) {
            $status = $this->_brontoStatus($subscriber);
        }
        $eventData = [
            'contact' => [
                'customer_id' => $subscriber->getCustomerId(),
                'email' => $subscriber->getSubscriberEmail(),
                'status' => $status
            ]
        ];
        $lists = [];
        if ($subscriber->getLocation() == 'checkout') {
            $sourceList = $this->_helper->getCheckoutSource('store', $subscriber->getStoreId());
            if (!empty($sourceList)) {
                $lists[] = $sourceList;
            }
        }
        if ($status == 'unsub') {
            $eventData['remove'] = [
                'lists' => array_merge($this->_helper->getRemoveFromListIds('store', $subscriber->getStoreId()), $lists)
            ];
        } else {
            $eventData['add'] = [
                'lists' => array_merge($this->_helper->getAddToListIds('store', $subscriber->getStoreId()), $lists)
            ];
        }
        return $eventData;
    }

    /**
     * Gets the Bronto status for the Magento code
     *
     * @param mixed $subscriber
     * @return string
     */
    private function _brontoStatus($subscriber)
    {
        switch ($subscriber->getSubscriberStatus()) {
            case 1:
                return 'onboarding';
            case 3:
                return 'unsub';
            case 4:
                return 'unconfirmed';
            default:
                return 'transactional';
        }
    }
}
