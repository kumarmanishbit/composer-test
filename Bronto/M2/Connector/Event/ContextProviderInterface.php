<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Connector\Event;

interface ContextProviderInterface
{
    /**
     * Creates an event context from a concrete object
     *
     * @param mixed $object
     * @return array
     */
    public function create($object);
}