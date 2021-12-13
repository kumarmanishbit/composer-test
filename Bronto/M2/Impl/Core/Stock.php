<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Impl\Core;

class Stock implements \Bronto\M2\Core\Stock\ManagerInterface
{
    protected $_stockRegistry;
    protected $_logger;

    /**
     * @param \Magento\CatalogInventory\Model\Spi\StockRegistryProviderInterface $stockRegistry
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\CatalogInventory\Model\Spi\StockRegistryProviderInterface $stockRegistry,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_stockRegistry = $stockRegistry;
        $this->_logger = $logger;
    }

    /**
     * @see parent
     */
    public function getByProductId($productId, $storeId = null)
    {
        try {
            return $this->_stockRegistry->getStockItem($productId, $storeId);
        } catch (\Exception $e) {
            $this->_logger->critical($e);
        }
        return null;
    }
}