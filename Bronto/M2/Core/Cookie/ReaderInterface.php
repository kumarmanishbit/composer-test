<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Core\Cookie;

interface ReaderInterface
{
    /**
     * Gets the cookie value, or a default value if none present
     *
     * @param string $name
     * @param string $defaultValue
     * @return string
     */
    public function getCookie($name, $defaultValue);
}
