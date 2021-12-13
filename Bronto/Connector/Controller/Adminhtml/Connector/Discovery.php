<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Controller\Adminhtml\Connector;

class Discovery extends \Bronto\Connector\Controller\Adminhtml\Connector
{
    /**
     * @see parent
     */
    protected function _execute($registration)
    {

        return $this->_connector->discovery($registration);
    }
}
