<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Controller\Adminhtml\Registration;

class Deregister extends \Bronto\Connector\Controller\Adminhtml\Registration
{
    /**
     * Performs an explicit deregistration to the Middleware
     *
     * @return void
     */
    public function execute()
    {
        $registration = $this->_registration();
        if ($registration->getId()) {
            try {
                $status = !$this->_middleware->deregister($registration);
                if (!$status) {
                    throw new \RuntimeException("Failed to deregister: {$registration->getName()}");
                }
                elseif ($status == -1) {
                    throw new \RuntimeException("{$registration->getName()}: This connection cannot be deleted due to existing dependencies. To view a list of these dependencies, please refer to the app configuration page.");
                }
                $this->messageManager->addSuccess(__('Successfully deregistered %1', $registration->getName()));
                $registration
                    ->setIsActive(false)
                    ->setUpdatedAt($this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate())
                    ->save();
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while deregistering this registration.'));
            }
        } else {
            $this->messageManager->addError(__("The registration could not be found."));
        }
        $this->_redirect('*/*/');
    }
}
