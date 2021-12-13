<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Product\Model;

class CategoryResolverFactory
{
    protected $_settings;
    protected $_objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Bronto\M2\Product\CategorySettingsInterface $settings
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Bronto\M2\Product\CategorySettingsInterface $settings
    ) {
        $this->_objectManager = $objectManager;
        $this->_settings = $settings;
    }

    /**
     * @see parent
     */
    public function aroundCreate($subject, $create, $resolver, $product)
    {
        $params = [
            'encapsulate' => $this->_settings->getCategoryEncapsulation('store', $product->getStoreId()),
            'delimiter' => $this->_settings->getCategoryDelimiter('store', $product->getStoreId()),
            'format' => $this->_settings->getCategoryFormat('store', $product->getStoreId()),
            'selection' => 'single',
            'specificity' => $this->_settings->getCategorySpecificity('store', $product->getStoreId()),
            'broadness' => $this->_settings->getCategoryBroadness('store', $product->getStoreId())
        ];
        switch ($resolver) {
            case 'tree':
                $params['selection'] = 'all';
                break;
            case 'all_leaves':
                $params['selection'] = 'leaves';
                break;
            case 'first_lowest':
                $params['selection'] = 'single';
                $params['specificity'] = 'lowest';
        }
        return $this->_objectManager->create('Bronto\M2\Core\Catalog\CategoryResolverInterface', $params);
    }
}