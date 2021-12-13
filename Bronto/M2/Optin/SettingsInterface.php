<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Optin;

interface SettingsInterface extends \Bronto\M2\Connector\Event\HelperInterface
{
    const XML_PATH_ENABLED = 'bronto/optin/extensions/settings/enabled';
    const XML_PATH_SYNC_UNSUBS = 'bronto/optin/extensions/settings/syncUnsubs';
    const XML_PATH_LISTS = 'bronto/optin/extensions/settings/lists';
    const XML_PATH_REMOVE_LISTS = 'bronto/optin/extensions/settings/removeLists';
    const XML_PATH_FORM_ENABLED = 'bronto/optin/extensions/form/enabled';
    const XML_PATH_FORM_SECRET = 'bronto/optin/extensions/form/secret';
    const XML_PATH_FORM_WEBFORM = 'bronto/optin/extensions/form/subscriberUrl';
    const XML_PATH_FORM_WEBFORM_HEIGHT = 'bronto/optin/extensions/form/height';
    const XML_PATH_CHECKOUT_ENABLED = 'bronto/optin/extensions/checkout/enabled';
    const XML_PATH_CHECKOUT_SOURCE = 'bronto/optin/extensions/checkout/source';
    const XML_PATH_CHECKOUT_LAYOUT = 'bronto/optin/extensions/checkout/layout';
    const XML_PATH_CHECKOUT_CHECKED = 'bronto/optin/extensions/checkout/checked';
    const XML_PATH_CHECKOUT_LABEL = 'bronto/optin/extensions/checkout/label';
    const CONTACT_TAG = '{CONTACT}';
    const VALIDATION_HASH = '{VALIDATION_HASH}';

    /**
     * Determines if Bronto unsubscriptions should be synced
     *
     * @param string $scopeType
     * @param mixed $scopeId
     * @return boolean
     */
    public function isSyncUnsub($scopeType = 'default', $scopeId = null);

    /**
     * Gets an array of list ids to add the contact to
     *
     * @param string $scopeType
     * @param mixed $scopeId
     * @return array
     */
    public function getAddToListIds($scopeType = 'default', $scopeId = null);

    /**
     * Gets an array of list ids to remove the contact from
     *
     * @param string $scopeType
     * @param mixed $scopeId
     * @return array
     */
    public function getRemoveFromListIds($scopeType = 'default', $scopeId = null);

    /**
     * Determines whether or not to display the webform
     *
     * @param string $scopeType
     * @param mixed $scopeId
     * @return boolean
     */
    public function isFormEnabled($scopeType = 'default', $scopeId = null);

    /**
     * Gets the webform subscriber url
     *
     * @param string $email
     * @param string $scopeType
     * @param mixed $scopeId
     * @return string
     */
    public function getWebformUrl($email, $scopeType = 'default', $scopeId = null);

    /**
     * Gets the webform height in pixels
     *
     * @param string $scopeType
     * @param mixed $scopeId
     * @return mixed
     */
    public function getWebformHeight($scopeType = 'default', $scopeId = null);

    /**
     * Determines if the checkout form is enabled
     *
     * @param string $scopeType
     * @param mixed $scopeId
     * @return boolean
     */
    public function isCheckoutEnabled($scopeType = 'default', $scopeId = null);

    /**
     * Gets the list associated with checkout subscriptions
     *
     * @param string $scopeType
     * @param mixed $scopeId
     * @return boolean
     */
    public function getCheckoutSource($scopeType = 'default', $scopeId = null);

    /**
     * Gets the checkout layout visibility
     *
     * @param string $scopeType
     * @param mixed $scopeId
     * @return string
     */
    public function getCheckoutLayout($scopeType = 'default', $scopeId = null);

    /**
     * Gets the checkout checkbox label
     *
     * @param string $scopeType
     * @param mixed $scopeId
     * @return string
     */
    public function getCheckoutLabel($scopeType = 'default', $scopeId = null);

    /**
     * Determines if the checkbox on checkout is checked by default
     *
     * @param string $scopeType
     * @param mixed $scopeId
     * @return boolean
     */
    public function isCheckedByDefault($scopeType = 'default', $scopeId = null);
}
