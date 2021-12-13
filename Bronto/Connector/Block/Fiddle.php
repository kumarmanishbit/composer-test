<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Block;

class Fiddle extends \Magento\Framework\View\Element\Template
{
    /**
     * Gets the fiddle url for AJAXy related fiddles
     *
     * @return string
     */
    public function getFiddleUrl()
    {
        $currentStore = $this->_storeManager->getStore(true);
        return $this->getUrl('bronto/site/fiddle', [
            '_secure' => $currentStore->isCurrentlySecure()
        ]);
    }
}
