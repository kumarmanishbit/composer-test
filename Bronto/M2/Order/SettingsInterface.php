<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Order;

use Magento\Sales\Api\Data\OrderInterface;

interface SettingsInterface extends \Bronto\M2\Connector\Event\HelperInterface
{
    const XML_PATH_ENABLED = 'bronto/order/extensions/settings/enabled';
    const XML_PATH_DESC = 'bronto/order/extensions/settings/description';
    const XML_PATH_STATUS = 'bronto/order/extensions/settings/status';
    const XML_PATH_IMAGE = 'bronto/order/extensions/settings/image_type';
    const XML_PATH_OTHER = 'bronto/order/extensions/settings/other_field';
    const XML_PATH_IMPORT = 'bronto/order/extensions/settings/import_status';
    const XML_PATH_DELETE = 'bronto/order/extensions/settings/delete_status';
    const XML_PATH_PRICE = 'bronto/order/extensions/settings/price';
    const XML_PATH_INCLUDE_DISCOUNT = 'bronto/order/extensions/settings/include_discount';
    const XML_PATH_INCLUDE_TAX = 'bronto/order/extensions/settings/include_tax';
    const XML_PATH_INCLUDE_SHIPPING = 'bronto/order/extensions/settings/include_shipping';

    /**
     * Determines if discounts should be included in the totals
     * (Old order service only)
     *
     * @param mixed $scope
     * @param mixed $scopeId
     * @return boolean
     */
    public function isIncludeDiscount($scope = 'default', $scopeId = null);

    /**
     * Determines if tax should be included in the totals
     * (Old order service only)
     *
     * @param mixed $scope
     * @param mixed $scopeId
     * @return boolean
     */
    public function isIncludeTax($scope = 'default', $scopeId = null);

    /**
     * Determines if a separate line item entry is included for shipping details
     * (Old order service only)
     *
     * @param mixed $scope
     * @param mixed $scopeId
     * @return boolean
     */
    public function isIncludeShipping($scope = 'default', $scopeId = null);

    /**
     * Determines if the values should be pulled from the base or display
     *
     * @param mixed $scope
     * @param mixed $scopeId
     * @return boolean
     */
    public function isBasePrice($scope = 'default', $scopeId = null);

    /**
     * Gets the attribute designated for product descriptions
     *
     * @param mixed $scope
     * @param mixed $scopeId
     * @return string
     */
    public function getDescriptionAttribute($scope = 'default', $scopeId = null);

    /**
     * Gets the attribute designated for the product image
     *
     * @param mixed $scope
     * @param mixed $scopeId
     * @return string
     */
    public function getImageAttribute($scope = 'default', $scopeId = null);

    /**
     * Creates a shipping line item for an order
     *
     * @param mixed $order
     * @return array
     */
    public function createShippingItem($order);

    /**
     * Gets all of the selected statuses to import
     *
     * @param string $scope
     * @param int $scopeId
     * @return array
     */
    public function getImportStatus($scope = 'default', $scopeId = null);

    /**
     * Gets al of the selected status to delete
     *
     * @param string $scope
     * @param int $scopeId
     * @return array
     */
    public function getDeleteStatus($scope = 'default', $scopeId = null);

    /**
     * Gets the Bronto order status to add
     *
     * @param string $scope
     * @param int $scopeId
     * @return string
     */
    public function getOrderStatus($scope = 'default', $scopeId = null);

    /**
     * Determines if the order is in a Magento Order state that is considered 'shipped' by Bronto
     *
     * @param OrderInterface $order
     * @return boolean
     */
    public function isShipped(OrderInterface $order);

    /**
     * Gets a category string for the order import
     *
     * @param string $scope
     * @param int $scopeId
     * @return string
     */
    public function getItemCategories($lineItem);

    /**
     * Gets the public item link for the line item
     *
     * @param string $scope
     * @param int $scopeId
     * @return string
     */
    public function getItemUrl($lineItem);

    /**
     * Gets the selected image property for the line item
     *
     * @param string $scope
     * @param int $scopeId
     * @return string
     */
    public function getItemImage($lineItem);

    /**
     * Gets the description for the line item
     *
     * @param string $scope
     * @param int $scopeId
     * @return string
     */
    public function getItemDescription($lineItem);

    /**
     * Gets the other field for the line item
     *
     * @param string $scope
     * @param int $scopeId
     * @return string
     */
    public function getItemOtherField($lineItem);

    /**
     * Gets the display name for the line item
     *
     * @param mixed $lineItem
     * @return string
     */
    public function getItemName($lineItem);

    /**
     * Gets the line item's static unit price
     *
     * @param mixed $lineItem
     * @param boolean $customerView
     * @param boolean $includeTax
     * @return float
     */
    public function getItemPrice($lineItem, $customerView = false, $includeTax = false);

    /**
     * Gets the line litem's discount
     *
     * @param mixed $lineItem
     * @param boolean $customerView
     * @return float
     */
    public function getItemDiscount($lineItem, $customerView = false);

    /**
     * Gets the line item's row total
     *
     * @param mixed $lineItem
     * @param boolean $customerView
     * @param boolean $includeTax
     * @return float
     */
    public function getItemRowTotal($lineItem, $customerView = false, $includeTax = false);

    /**
     * Gets a collection of simple and complex line items
     * in a flat collection
     *
     * @param mixed
     * @return array
     */
    public function getFlatItems($object);

    /**
     * Gets the visible product
     *
     * @param mixed $lineItem
     * @return mixed
     */
    public function getVisibleProduct($lineItem);

    /**
     * Formats the price using whatever code the price was
     * placed in
     *
     * @param float $price
     * @return string
     */
    public function formatPrice($price, $useDisplaySymbol = true);

    /**
     * Sets the currency to be used in locale formatting
     *
     * @param string $code
     * @return self
     */
    public function setCurrency($code);
}