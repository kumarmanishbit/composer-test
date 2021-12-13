<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Connector;

interface RedirectorInterface
{
    /**
     * Handles an observer to perform any redirects
     *
     * @param mixed $observer
     * @return void
     */
    public function redirectPath($observer);
}
