<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Core\Catalog;

class ProductCategoryResolverImpl implements ProductCategoryResolverInterface
{
    protected $_categoryRepo;
    protected $_resolverFactory;

    /**
     * @param \Bronto\M2\Core\Catalog\CategoryCacheInterface $categoryRepo
     * @param \Bronto\M2\Core\Catalog\CategoryResolverFactoryInterface $resolverFactory
     */
    public function __construct(
        \Bronto\M2\Core\Catalog\CategoryCacheInterface $categoryRepo,
        \Bronto\M2\Core\Catalog\CategoryResolverFactoryInterface $resolverFactory
    ) {
        $this->_categoryRepo = $categoryRepo;
        $this->_resolverFactory = $resolverFactory;
    }

    /**
     * @see parent
     */
    public function getCategory($product, $resolver = 'single')
    {
        $branches = [];
        $currentBranch = [];
        $currentPrefix = '';
        foreach ($product->getCategoryIds() as $categoryId) {
            $category = $this->_categoryRepo->getById($categoryId, $product->getStoreId());
            if ($category && $category->getLevel() > 1) {
                if (empty($currentPrefix) || !preg_match('|^' . $currentPrefix . '|', $category->getPath())) {
                    if (!empty($currentBranch)) {
                        $branches[] = $currentBranch;
                    }
                    $currentPrefix = $category->getPath();
                    $currentBranch = [];
                }
                $currentBranch[] = $category;
            }
        }
        if (!empty($currentBranch)) {
            $branches[] = $currentBranch;
        }
        return $this->_resolverFactory->create($resolver, $product)->resolve($branches);
    }
}
