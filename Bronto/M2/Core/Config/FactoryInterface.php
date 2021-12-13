<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Core\Config;

interface FactoryInterface
{
    /**
     * Gets the resource collection representative of a config DB
     *
     * @return mixed
     */
    public function getCollection();
}
