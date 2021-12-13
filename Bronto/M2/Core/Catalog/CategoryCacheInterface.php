<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Core\Catalog;

interface CategoryCacheInterface
{
    /**
     * Retrieves the catalog from a local cache or pulls a fresh one
     *
     * @param mixed $catalogId
     * @param mixed $storeId
     * @return mixed
     */
    public function getById($catalogId, $storeId = null);

    /**
     * Retrieves a list of categories based on the source object
     *
     * @param \Bronto\M2\Connector\Discovery\Source $source
     * @return mixed
     */
    public function getBySource(\Bronto\M2\Connector\Discovery\Source $source);
}
