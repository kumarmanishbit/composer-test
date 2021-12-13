<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Model\ResourceModel;

use Bronto\Connector\Model\Spi\TidResourceInterface;
use Bronto\Connector\Setup\InstallSchema;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Tid
 * @package Bronto\Connector\Model\ResourceModel
 */
class Tid extends AbstractDb implements TidResourceInterface
{
    /**
     * Tid Constructor.
     */
    protected function _construct()
    {
        $this->_init(InstallSchema::TID_TABLE, 'id');
    }
}