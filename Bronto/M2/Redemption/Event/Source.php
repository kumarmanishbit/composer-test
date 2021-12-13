<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Redemption\Event;

class Source implements \Bronto\M2\Connector\Event\SourceInterface
{
    protected $_settings;

    /**
     * @param \Bronto\M2\Order\SettingsInterface $settings
     */
    public function __construct(
        \Bronto\M2\Order\SettingsInterface $settings
    ) {
        $this->_settings = $settings;
    }

    /**
     * @see parent
     */
    public function getEventType()
    {
        return 'couponManager';
    }

    /**
     * @see parent
     */
    public function action($order)
    {
        $couponCode = $order->getCouponCode();
        return !empty($couponCode) ? 'add' : '';
    }

    /**
     * @see parent
     */
    public function transform($order)
    {
        $isBase = $this->_settings->isBasePrice('store', $order->getStoreId());
        return [
            'redemptions' => [
                [
                    'email' => $order->getCustomerEmail(),
                    'coupon' => $order->getCouponCode(),
                    'orderId' => $order->getIncrementId(),
                    'orderSubtotal' => $isBase ?
                        $order->getBaseSubtotal() :
                        $order->getSubtotal(),
                    'orderDiscount' => $isBase ?
                        $order->getBaseDiscountAmount() :
                        $order->getDiscountAmount(),
                    'date' => date('c', strtotime($order->getCreatedAt()))
                ]
            ]
        ];
    }
}
