<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Integration;

class CouponSettings extends \Bronto\M2\Core\Config\ContainerAbstract implements CouponSettingsInterface
{
    /**
     * @see parent
     */
    public function isCouponEnabled($scopeType = 'default', $scopeId = null)
    {
        return $this->_config->isSetFlag(self::XML_PATH_COUPON_ENABLED, $scopeType, $scopeId);
    }
}
