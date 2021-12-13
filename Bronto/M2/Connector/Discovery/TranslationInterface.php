<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Connector\Discovery;

interface TranslationInterface
{
    /**
     * Performs a translation on any string
     *
     * @param string $string
     * @return string
     */
    public function translate($string);
}
