<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Core\Customer;

interface GroupCacheInterface
{
    /**
     * Gets a customer group by the group id
     *
     * @param int $groupId
     * @return mixed
     */
    public function getById($groupId);
}
