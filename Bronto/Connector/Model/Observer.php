<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Model;

class Observer extends \Bronto\M2\Advanced\ExtensionAbstract
{
    /**
     * @see parent
     */
    public function translate($message)
    {
        return __($message);
    }
}
