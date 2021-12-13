<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Inventory\Model;

class Manager extends \Bronto\M2\Impl\Core\Stock implements \Bronto\M2\Product\CatalogMapperManagerInterface
{
    /**
     * @see parent
     */
    public function getByProduct($product)
    {
        return $this->getByProductId($product->getId(), $product->getStoreId());
    }
}
