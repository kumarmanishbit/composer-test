<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Controller\Adminhtml\Registration;

class Index extends \Bronto\Connector\Controller\Adminhtml\Registration
{
    /**
     * @see parent
     * @return void
     */
    public function execute()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            $this->_forward('grid');
        } else {
            $this->_view->loadLayout();
            $this->_setActiveMenu('Bronto_Connector::registration');
            $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Responsys Connector'));
            $this->_addBreadcrumb(
                __('Bronto Connector Registrations'),
                __('Bronto Connector Registrations')
            );
            $this->_view->renderLayout();
        }
    }
}
