<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Contact;

interface SettingsInterface extends \Bronto\M2\Connector\Event\HelperInterface
{
    const XML_PATH_ENABLED = 'bronto/contact/extensions/settings/enabled';
    const XML_PATH_SKIP_EMPTY = 'bronto/contact/extensions/settings/skipEmpty';
    const XML_PATH_GUEST_ORDER = 'bronto/contact/extensions/settings/guestOrder';

    /**
     * Determines wheter or not to skip empty field values
     *
     * @return boolean
     */
    public function isSkipEmpty($scopeType = 'default', $scopeId = null);

    /**
     * Gets the guest order contact field toggle
     *
     * @param string $scopeType
     * @param mixed $scopeId
     * @return string
     */
    public function getGuestOrderToggle($scopeType = 'default', $scopeId = null);

    /**
     * Gets the labels for the attribute sections
     *
     * @return array
     */
    public function getAttributeLabels();

    /**
     * Get the attribute filters
     *
     * @return array
     */
    public function getAttributeFilters();

    /**
     * Gets the attributes for the endpoint
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Gets the attribute display type
     *
     * @param mixed $attribute
     * @return string
     */
    public function getAttributeDisplayType($attribute);

    /**
     * Gets the fields for a Magento model of some kind
     *
     * @param mixed $object
     * @param mixed $storeId
     * @param string $type
     * @return array
     */
    public function getFieldsForModel($object, $storeId, $type = 'contact');
}
