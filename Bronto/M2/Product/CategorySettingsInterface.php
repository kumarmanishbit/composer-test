<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Product;

interface CategorySettingsInterface
{
    const XML_PATH_ENCAPSULATION = 'bronto/product/extensions/settings/categoryBranchDelimiter';
    const XML_PATH_FORMAT = 'bronto/product/extensions/settings/categoryFormat';
    const XML_PATH_DELIMITER = 'bronto/product/extensions/settings/categoryDelimiter';
    const XML_PATH_SPECIFICITY = 'bronto/product/extensions/settings/categorySpecificity';
    const XML_PATH_BROADNESS = 'bronto/product/extensions/settings/categoryBroadness';

    /**
     * @param string $scope
     * @param mixed $scopeId
     * @return string
     */
    public function getCategoryEncapsulation($scope = 'default', $scopeId = null);

    /**
     * @param string $scope
     * @param mixed $scopeId
     * @return string
     */
    public function getCategoryDelimiter($scope = 'default', $scopeId = null);

    /**
     * @param string $scope
     * @param mixed $scopeId
     * @return string
     */
    public function getCategoryFormat($scope = 'default', $scopeId = null);

    /**
     * @param string $scope
     * @param mixed $scopeId
     * @return string
     */
    public function getCategorySpecificity($scope = 'default', $scopeId = null);

    /**
     * @param string $scope
     * @param mixed $scopeId
     * @return string
     */
    public function getCategoryBroadness($scope = 'default', $scopeId = null);
}
