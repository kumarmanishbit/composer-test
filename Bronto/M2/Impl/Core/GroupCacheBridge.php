<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Impl\Core;

class GroupCacheBridge implements \Bronto\M2\Core\Customer\GroupCacheInterface
{
    protected $_groupRepo;

    /**
     * @param \Magento\Customer\Api\GroupRepositoryInterface $groupRepo
     */
    public function __construct(
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepo
    ) {
        $this->_groupRepo = $groupRepo;
    }

    /**
     * @see parent
     */
    public function getById($groupId)
    {
        try {
            return $this->_groupRepo->getById($groupId);
        } catch (\Exception $e) {
            return null;
        }
    }
}
