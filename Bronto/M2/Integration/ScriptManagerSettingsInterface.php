<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Integration;


interface ScriptManagerSettingsInterface
{
    const XML_PATH_SCRIPT_ENABLED = 'bronto/integration/extensions/script_manager/enabled';

    const SNIPPET_ENDPOINT_PREFIX = "https://cdn.bronto.com/bsm-snippet/";
// bronto/integration/extensions/script_manager/enabled : 1
    /**
     * @param string $scopeType
     * @param int $scopeId
     * @return bool
     */
    public function isEnabled($scopeType = 'default', $scopeId = null);
}
