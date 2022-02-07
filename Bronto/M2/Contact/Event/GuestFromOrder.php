<?php
/*
 * Copyright © 2021, 2022 Oracle and/or its affiliates.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Contact\Event;

class GuestFromOrder implements \Bronto\M2\Connector\Event\SourceInterface, \Bronto\M2\Connector\Event\ContextProviderInterface
{
    protected $_helper;

    /**
     * @param \Bronto\M2\Contact\SettingsInterface $helper
     */
    public function __construct(
        \Bronto\M2\Contact\SettingsInterface $helper
    ) {
        $this->_helper = $helper;
    }

    /**
     * @see parent
     */
    public function create($order)
    {
        return [
            'type' => 'order',
            'uniqueKey' => 'contact.order.' . $order->getId()
        ];
    }

    /**
     * @see parent
     */
    public function getEventType()
    {
        return 'contact';
    }

    /**
     * @see parent
     */
    public function action($order)
    {
        return $order->getCustomerIsGuest() ? 'add' : '';
    }

    /**
     * @see parent
     */
    public function transform($order)
    {
        return [
            'email' => $order->getCustomerEmail(),
            'status' => 'transactional',
            'fields' => $this->_helper->getFieldsForModel($order, $order->getStore(), 'order')
        ];
    }
}
