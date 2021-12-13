<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Impl;

class CurlAdapter
{
    /**
     * Magento DI has some really WTF moments sometimes
     */
    public function aroundCreateRequest($subject, $createReq, $method, $uri)
    {
        return new \Bronto\Transfer\Curl\Request($method, $uri, new \Bronto\DataObject());
    }
}
