<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Connector\Event;

use Bronto\Connector\Model\Registration;

interface PlatformInterface
{
    /**
     * Annotate an event with infromation
     *
     * @param \Bronto\M2\Connector\Model\Event\SourceInterface $source
     * @param mixed $object
     * @param string $action
     * @param mixed $storeId
     * @param array $context
     * @return array
     */
    public function annotate(SourceInterface $source, $object, $action = null, $storeId = null, $context = [],
                             Registration $registration);

    /**
     * Dispatches an annotated event
     *
     * @param array $event
     * @return boolean
     */
    public function dispatch($event);

    /**
     * Dispatches an annotated event to responsys
     *
     * @param array $event
     * @return boolean
     */
    public function dispatchToResponsys($event);

    /**
     * Gets the platform version for the platform
     *
     * @return string
     */
    public function platformVersion();

    /**
     * Gets the extension version for the platform
     *
     * @return string
     */
    public function extensionVersion();
}
