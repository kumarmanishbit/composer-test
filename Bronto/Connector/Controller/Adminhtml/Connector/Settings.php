<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Controller\Adminhtml\Connector;

class Settings extends \Bronto\Connector\Controller\Adminhtml\Connector
{
    /**
     * @see parent
     */
    protected function _execute($registration)
    {
        $needsUpdate = $this->getRequest()->getParam('changed') == 'true';
        $needsTrigger = $this->getRequest()->getParam('trigger', 'true') == 'true';
        // sync is the place from where they make the save configuration call to db
        $success = (!$needsUpdate || $this->_middleware->sync($registration));
        $success = $success && (!$needsTrigger || $this->_middleware->triggerFlush($registration));
        if ($success) {
            return ['message' => 'success'];
        } else {
            return ['message' => 'failed', 'code' => 400];
        }
    }
}
