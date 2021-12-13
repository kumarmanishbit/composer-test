<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Core\Directory;

interface CurrencyManagerInterface
{
    /**
     * Retrieves a currency code from a cache or DB
     *
     * @param string $code
     * @return \Magento\Directory\Model\Currency
     */
    public function getByCode($code);
}
