<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Product;

interface CatalogMapperManagerInterface
{
    /**
     * Gets some external object containing fields
     *
     * @return mixed
     */
    public function getByProduct($product);
}
