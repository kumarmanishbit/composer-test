<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Impl\Core;

class CategoryResolverFactory implements \Bronto\M2\Core\Catalog\CategoryResolverFactoryInterface
{
    const RESOLVER = 'Bronto\M2\Core\Catalog\CategoryResolverInterface';

    protected $_objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        $this->_objectManager = $objectManager;
    }

    /**
     * @see parent
     */
    public function create($resolver, $product)
    {
        return $this->_objectManager->create(self::RESOLVER);
    }
}