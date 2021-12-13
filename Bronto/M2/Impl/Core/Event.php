<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Impl\Core;

class Event implements \Bronto\M2\Core\Event\ManagerInterface
{
    private $_events;

    public function __construct(
        \Magento\Framework\Event\ManagerInterface $events
    ) {
        $this->_events = $events;
    }

    /**
     * @see parent
     */
    public function dispatch($eventName, array $data = [])
    {
        $this->_events->dispatch($eventName, $data);
    }
}
