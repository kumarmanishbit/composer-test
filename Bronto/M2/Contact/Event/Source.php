<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Contact\Event;

class Source implements \Bronto\M2\Connector\Event\SourceInterface, \Bronto\M2\Connector\Event\ContextProviderInterface
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
    public function create($customer)
    {
        return [
          'updated_email' => $customer->dataHasChangedFor('email') ?
              $customer->getOrigData('email') :
              $customer->getEmail(),
          'uniqueKey' => implode('.', [
              $this->getEventType(),
              $this->action($customer),
              $customer->getId()
          ])
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
    public function action($customer)
    {
        return $customer->getIsUpdateEmail() ? 'update' : 'add';
    }

    /**
     * @see parent
     */
    public function transform($customer)
    {
        if ($customer->getIsUpdateEmail() && $customer->dataHasChangedFor('email')) {
            return [
                'id' => $customer->getOrigData('email'),
                'email' => $customer->getEmail()
            ];
        } else {
            return [
                'email' => $customer->getEmail(),
                'status' => 'transactional',
                'fields' => $this->_helper->getFieldsForModel($customer, $customer->getStore())
            ];
        }
    }
}
