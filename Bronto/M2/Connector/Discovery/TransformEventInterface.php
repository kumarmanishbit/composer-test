<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Connector\Discovery;

interface TransformEventInterface
{
    /**
     * This extension will transform queued events into Sarlacc data
     *
     * @param mixed $observer
     * @return void
     */
    public function transformEvent($observer);
}
