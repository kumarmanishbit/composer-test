<?php
/*
 * Copyright © 2021, 2022 Oracle and/or its affiliates.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Email\Model\ResourceModel;

use Bronto\Email\Setup\InstallSchema;

class Trigger extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @see parent
     */
    protected function _construct()
    {
        $this->_init(InstallSchema::TRIGGER_TABLE, 'trigger_id');
    }
}
