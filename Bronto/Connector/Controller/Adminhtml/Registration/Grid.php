<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Controller\Adminhtml\Registration;

class Grid extends \Bronto\Connector\Controller\Adminhtml\Registration
{
    /**
     * @see parent
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout(false);
        $this->_view->getLayout()
            ->getMessagesBlock()
            ->setMessages($this->messageManager->getMessages(true));
        $this->_view->renderLayout();
    }
}
