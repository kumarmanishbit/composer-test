<?php

namespace Bronto\M2\Balance;

interface ManagerInterface
{
    /**
     * Loads customer balance for a given customer for a given website
     *
     * @param mixed $customerId
     * @param mixed $websiteId
     * @return mixed
     */
    public function getByCustomer($customerId, $websiteId);
}
