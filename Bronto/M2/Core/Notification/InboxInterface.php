<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Core\Notification;

interface InboxInterface
{
    /**
     * Creates a Magento admin notification with information
     *
     * @param string $title
     * @param string $description
     * @param string $url
     * @return boolean
     */
    public function addNotice($title, $description, $url);

    /**
     * Marks the notification as read
     *
     * @param mixed $notificationId
     * @return void
     */
    public function markAsRead($notificationId);
}