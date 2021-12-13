<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Connector\Event;

interface HelperInterface
{
    /**
     * Determines event enablement for the various extensions
     *
     * @param string $scope
     * @param int $scopeId
     * @return boolean
     */
    public function isEnabled($scope = 'default', $scopeId = null);
}
