<?php
/*
 * Copyright © 2021, 2022 Oracle and/or its affiliates.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Coupon;

interface ManagerInterface
{
    const XML_PATH_OBJECT_PATH = 'bronto/coupon/objects/generator/%';

    /**
     * Gets all of the generators created in Connector
     *
     * @param \Bronto\M2\Connector\RegistrationInterface $registration
     * @return array
     */
    public function getAll(\Bronto\M2\Connector\RegistrationInterface $registration);

    /**
     * Gets a single generator created in Connector
     *
     * @param string $generatorId
     * @param boolean $force
     * @return array
     */
    public function getById($generatorId, $force = false);

    /**
     * Saves a single generator
     *
     * @param string $generatorId
     * @param array $generator
     * @param \Bronto\M2\Connector\RegistrationInterface $registration
     * @return array
     */
    public function save($generatorId, $generator, \Bronto\M2\Connector\RegistrationInterface $registration);

    /**
     * Increments the replenish count for a generator
     * Returns a collection of coupons that were generated
     *
     * @param mixed $generator
     * @param int $amount
     * @return array
     */
    public function acquireCoupons($generator, $amount = null);

    /**
     * Generates one unique coupon code from a specific generator
     *
     * @param string $generatorId
     * @return string
     */
    public function acquireCoupon($generatorId);

    /**
     * Gets all of the replenishable pools from the platform
     *
     * @param \Bronto\M2\Connector\RegistrationInterface $registration
     * @return array
     */
    public function getReplenishablePoolIds(\Bronto\M2\Connector\RegistrationInterface $registration);
}
