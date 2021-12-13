<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Controller\Site;

class Fiddle extends \Magento\Framework\App\Action\Action
{
    const FIDDLE_EVENT = 'bronto_site_fiddle';

    /**
     * @see parent
     */
    public function execute()
    {
        $this->_eventManager->dispatch(self::FIDDLE_EVENT, [
            'request' => $this->getRequest()
        ]);
        return $this->getResponse();
    }
}