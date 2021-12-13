<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Controller\Adminhtml\Registration;

class NewAction extends \Bronto\Connector\Controller\Adminhtml\Registration
{
    /**
     * Forwards to the edit action
     *
     * @return void
     */
    public function execute()
    {
        // _forward() protected function will edit the request to transfer it to another controller/action class.
        // This will not change the request url.
        $this->_forward('edit');
    }
}
