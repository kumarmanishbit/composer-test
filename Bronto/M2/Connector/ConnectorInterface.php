<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Connector;

interface ConnectorInterface
{
    /**
     * Creates a scope tree for the registration
     *
     * @param \Bronto\Connector\Model\RegistrationInterface $model
     * @return array
     */
    public function scopeTree(RegistrationInterface $model);

    /**
     * Creates a discovery object for the registration
     *
     * @param \Bronto\Connector\Model\RegistrationInterface $model
     * @return array
     */
    public function discovery(RegistrationInterface $model);

    /**
     * Creates an endpoint object for the registration and service
     *
     * @param \Bronto\M2\Connector\RegistrationInterface $model
     * @param string $serviceName
     * @return array
     */
    public function endpoint(RegistrationInterface $model, $serviceName);

    /**
     * Performs an immediate script execution for the Middleware
     *
     * @param \Bronto\M2\Connector\RegistrationInterface $model
     * @param array $script
     * @return array
     */
    public function executeScript(RegistrationInterface $model, $script);

    /**
     * Performs an immediate source lookup from the Middleware
     *
     * @param \Bronto\M2\Connector\RegistrationInterface $model
     * @param string $sourceId
     * @param array $params
     * @return array
     */
    public function source(RegistrationInterface $model, $sourceId, $params = []);

    /**
     * Syncs the stored settings from connector
     *
     * @param \Bronto\M2\Connector\RegistrationInterface $model
     * @return array
     */
    public function settings(RegistrationInterface $model);

    /**
     * @param \Bronto\M2\Connector\RegistrationInterface $model
     * @return string
     */
    public function getEik(RegistrationInterface $model);

    /**
     * Sorts and flattens out any settings annotated with a sort_order
     *
     * @param array $settings
     * @return array
     */
    public function sortAndSet(array $settings);
}
