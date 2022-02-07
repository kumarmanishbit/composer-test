<?php
/*
 * Copyright © 2021, 2022 Oracle and/or its affiliates.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Cart\Model;

class Observer extends \Bronto\M2\Cart\ExtensionAbstract
{
    /**
     * @see parent
     */
    public function translate($message)
    {
        return __($message);
    }
}
