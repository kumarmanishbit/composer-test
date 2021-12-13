<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Controller\Adminhtml\Registration;

class Settings extends \Bronto\Connector\Controller\Adminhtml\Registration
{
    /**
     * Performs a settings sync transfer
     *
     * @return void
     */
    public function execute()
    {
        $registration = $this->_registration();
        if ($registration->getId()) {
            try {
                if (!$registration->getIsActive()) {
                    throw new \RuntimeException("{$registration->getName()} is not active.");
                }
                if (!$this->_middleware->sync($registration)) {
                    throw new \RuntimeException("Failed to sync: {$registration->getName()}");
                }
                $this->messageManager->addSuccess(__('Successfully synced %1.', $registration->getName()));
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __($e->getMessage()));
            }
        } else {
            $this->messageManager->addError(__("The registration could not be found."));
        }
        return $this->_redirect('*/*/index');
    }
}
