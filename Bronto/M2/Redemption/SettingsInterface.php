<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Redemption;

interface SettingsInterface extends \Bronto\M2\Connector\Event\HelperInterface
{
    const XML_PATH_API_TOGGLE = 'bronto/integration/extensions/coupon_manager/toggle_api';

    /**
     * Determines if the user has turned on REST API intergration
     *
     * @param string $scope
     * @param mixed $scopeId
     * @return boolean
     */
    public function isToggled($scope = 'default', $scopeId = null);
}
