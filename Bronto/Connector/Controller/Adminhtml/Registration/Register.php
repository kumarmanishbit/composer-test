<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Controller\Adminhtml\Registration;

class Register extends \Bronto\Connector\Controller\Adminhtml\Registration
{
    /**
     * Performs an explicit registration to the Middleware
     *
     * @return void
     */
    public function execute()
    {
        $registration = $this->_registration();
        if ($registration->getId()) {
            try {
                if (!$this->_middleware->register($registration)) {
                    throw new \RuntimeException("Failed to register: {$registration->getName()}");
                }
                $this->messageManager->addSuccess(__('Successfuly registered %1', $registration->getName()));
                $registration
                    ->setIsActive(true)
                    ->setUpdatedAt($this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate())
                    ->save();
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while registering this registration.'));
            }
        } else {
            $this->messageManager->addError(__("The registration could not be found."));
        }
        $this->_redirect('*/*/');
    }
}
