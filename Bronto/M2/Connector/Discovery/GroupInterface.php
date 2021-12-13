<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Connector\Discovery;

interface GroupInterface
{
    /**
     * Gets the sort order of the extension group
     *
     * @return int
     */
    public function getSortOrder();

    /**
     * Gets the extension group id
     *
     * @return string
     */
    public function getEndpointId();

    /**
     * Gets the endpoint name
     *
     * @return string
     */
    public function getEndpointName();

    /**
     * Gets the connector icon for this extension group
     *
     * @return string
     */
    public function getEndpointIcon();
}
