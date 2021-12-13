<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\M2\Connector\Discovery;

abstract class ExtensionPushEventAbstract implements \Bronto\M2\Connector\Discovery\PushChangesInterface, \Bronto\M2\Connector\Discovery\TranslationInterface
{
    /** @var \Bronto\M2\Connector\Event\HelperInterface */
    protected $_helper;

    /** @var \Bronto\M2\Connector\Event\PlatformInterface */
    protected $_platform;

    /** @var \Bronto\M2\Connector\Event\SourceInterface */
    protected $_source;

    /** @var \Bronto\M2\Connector\Event\PushLogic */
    protected $_pushLogic;

    /** @var \Bronto\M2\Core\Store\ManagerInterface */
    protected $_storeManager;

    /** @var \Bronto\M2\Connector\SettingsInterface */
    protected $_connectorSettings;

    /**
     * @param \Bronto\M2\Core\Store\ManagerInterface $storeManager
     * @param \Bronto\M2\Connector\QueueManagerInterface $queueManager
     * @param \Bronto\M2\Connector\SettingsInterface $connectorSettings
     * @param \Bronto\M2\Connector\Event\HelperInterface $helper
     * @param \Bronto\M2\Connector\Event\PlatformInterface $platform
     * @param \Bronto\M2\Connector\Event\SourceInterface $source
     */
    public function __construct(
        \Bronto\M2\Core\Store\ManagerInterface $storeManager,
        \Bronto\M2\Connector\QueueManagerInterface $queueManager,
        \Bronto\M2\Connector\SettingsInterface $connectorSettings,
        \Bronto\M2\Connector\Event\HelperInterface $helper,
        \Bronto\M2\Connector\Event\PlatformInterface $platform,
        \Bronto\M2\Connector\Event\SourceInterface $source
    ) {
        $this->_helper = $helper;
        $this->_platform = $platform;
        $this->_source = $source;
        $this->_storeManager = $storeManager;
        $this->_connectorSettings = $connectorSettings;
        $this->_pushLogic = new \Bronto\M2\Connector\Event\PushLogic(
            $queueManager,
            $connectorSettings,
            $helper,
            $platform,
            $source,
            $this->_contextProvider()
        );
    }

    /**
     * @see \Bronto\M2\Connector\Discovery\PushChangesInterface::pushChanges
     * @param \Magento\Framework\Event\Observer|\Bronto\M2\Core\DataObject $observer
     */
    public function pushChanges($observer)
    {
        $object = $this->_getObject($observer);
        $storeId = $object->getStoreId();
        if (is_null($storeId) || $storeId === false) {
            $storeId = true;
        }
        $this->_pushLogic->pushEvent($object, $storeId);
    }

    /**
     * Yanks the object out of this observed change
     *
     * @param mixed $observer
     * @return mixed
     */
    protected function _getObject($observer)
    {
        return $observer->getData($this->_source->getEventType());
    }

    /**
     * Gets a context provider transformer
     *
     * @return \Bronto\M2\Connector\Event\ContextProviderInterface|null
     */
    protected function _contextProvider()
    {
        return null;
    }

    /**
     * @param \Bronto\M2\Connector\Event\HelperInterface $helper
     * @return self
     */
    protected function setHelper(\Bronto\M2\Connector\Event\HelperInterface $helper)
    {
        $this->_helper = $helper;
        return $this;
    }

    /**
     * @return \Bronto\M2\Connector\Event\HelperInterface
     */
    protected function getHelper()
    {
        return $this->_helper;
    }
}
