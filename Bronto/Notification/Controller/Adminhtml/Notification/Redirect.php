<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Notification\Controller\Adminhtml\Notification;

class Redirect extends \Bronto\Notification\Controller\Adminhtml\Notification
{
    /**
     * @see parent
     */
    public function execute()
    {
        $url = $this->getRequest()->getParam('url', false);
        $id = $this->getRequest()->getParam('id', false);
        $redirect = $this->resultRedirectFactory->create();
        if ($url && $id) {
            $redirectPath = $this->_decrypt($url);
            $notificationId = $this->_decrypt($id);
            $this->_service->markAsRead($notificationId);
            $redirect->setUrl($redirectPath);
            return $redirect;
        }
        return $redirect->setPath("/");
    }
}
