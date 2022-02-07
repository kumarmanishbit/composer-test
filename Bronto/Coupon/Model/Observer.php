<?php
/*
 * Copyright © 2021, 2022 Oracle and/or its affiliates.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Coupon\Model;

class Observer extends \Bronto\M2\Coupon\ExtensionAbstract
{
    protected $_formatHelper;

    /**
     * @param \Magento\SalesRule\Helper\Coupon $formatHelper
     * @param \Bronto\M2\Core\Sales\RuleManagerInterface $rules
     * @param \Bronto\M2\Coupon\ManagerInterface $manager
     * @param \Bronto\M2\Connector\MiddlewareInterface $middleware
     * @param \Bronto\M2\Core\App\EmulationInterface $appEmulation
     * @param \Bronto\M2\Core\Store\ManagerInterface $storeManager
     * @param \Bronto\M2\Connector\QueueManagerInterface $queueManager
     * @param \Bronto\M2\Connector\SettingsInterface $connectorSettings
     * @param \Bronto\M2\Coupon\SettingsInterface $helper
     * @param \Bronto\M2\Connector\Event\PlatformInterface $platform
     * @param \Bronto\M2\Connector\Event\SourceInterface $source
     * @param \Magento\Framework\Filesystem\DriverInterface $fileSystemDriver
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\SalesRule\Helper\Coupon $formatHelper,
        \Bronto\M2\Core\Sales\RuleManagerInterface $rules,
        \Bronto\M2\Coupon\ManagerInterface $manager,
        \Bronto\M2\Connector\MiddlewareInterface $middleware,
        \Bronto\M2\Core\App\EmulationInterface $appEmulation,
        \Bronto\M2\Core\Store\ManagerInterface $storeManager,
        \Bronto\M2\Connector\QueueManagerInterface $queueManager,
        \Bronto\M2\Connector\SettingsInterface $connectorSettings,
        \Bronto\M2\Coupon\SettingsInterface $helper,
        \Bronto\M2\Connector\Event\PlatformInterface $platform,
        \Bronto\M2\Coupon\Event\Source $source,
        \Magento\Framework\Filesystem\DriverInterface $fileSystemDriver,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct(
            $rules,
            $manager,
            $middleware,
            $appEmulation,
            $storeManager,
            $queueManager,
            $connectorSettings,
            $helper,
            $platform,
            $source,
            $fileSystemDriver,
            $logger
        );
        $this->_formatHelper = $formatHelper;
    }

    /**
     * @see parent
     */
    public function translate($message)
    {
        return __($message);
    }

    /**
     * @see parent
     */
    protected function _couponFormats()
    {
        $formats = [];
        foreach ($this->_formatHelper->getFormatsList() as $id => $name) {
            $formats[] = [ 'id' => $id, 'name' => $name ];
        }
        return $formats;
    }
}
