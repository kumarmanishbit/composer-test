<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Cart;

interface SettingsInterface extends \Bronto\M2\Integration\CartSettingsInterface, \Bronto\M2\Connector\Event\HelperInterface
{
    const XML_PATH_API_TOGGLE = 'bronto/integration/extensions/cart_recovery/toggle_api';
    const XML_PATH_RECOVERY_EMAIL = 'bronto/integration/extensions/cart_recovery/selectors';

    /**
     * Determines if the user turned on REST API integration or not
     *
     * @param string $scope
     * @param mixed $scopeId
     * @return boolean
     */
    public function isToggled($scope = 'default', $scopeId = null);

    /**
     * Gets the CSS selectors used to observe for guest abandons
     *
     * @param string $scope
     * @param mixed $scopeId
     * @return string
     */
    public function getCartRecoverySelectors($scope = 'default', $scopeId = null);

    /**
     * Encodes and encrypts the email value for cookie storage
     *
     * @param string $email
     * @return string
     */
    public function setCartRecoveryCookie($email);
}
