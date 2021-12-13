<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Core\Catalog;

interface CategoryResolverFactoryInterface
{
    /**
     * Creates a category resolver from a product
     *
     * @param string $resolver
     * @param mixed $product
     * @return CategoryResolverInterface
     */
    public function create($resolver, $product);
}
