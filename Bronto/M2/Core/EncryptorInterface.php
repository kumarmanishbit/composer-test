<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Core;

interface EncryptorInterface
{
    /**
     * Forwards implementation calls to the platform
     *
     * @param string $message
     * @return string
     */
    public function encrypt($message);

    /**
     * Forwards implementation calls to the platform
     *
     * @param string $message
     * @return string
     */
    public function decrypt($message);
}
