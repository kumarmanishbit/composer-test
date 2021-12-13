<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Notification;

interface SettingsInterface extends \Bronto\M2\Connector\Event\HelperInterface
{
    const XML_PATH_ENABLED = 'bronto/advanced/extensions/settings/notification_enabled';
    const XML_PATH_EMAIL = 'bronto/advanced/extensions/settings/notification_email';

    public function getNotificationEmail($scope = 'default', $scopeId = null);
}
