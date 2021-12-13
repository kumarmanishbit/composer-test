<?php

namespace Bronto\M2\Reward;

interface ManagerInterface
{
    /**
     * Loads reward points for a given customer for a given website
     *
     * @param mixed $customerId
     * @param mixed $websiteId
     * @return mixed
     */
    public function getByCustomer($customerId, $websiteId);
}
