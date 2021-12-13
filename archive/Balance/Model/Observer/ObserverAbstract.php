<?php

namespace Bronto\Balance\Model\Observer;

abstract class ObserverAbstract implements \Magento\Framework\Event\ObserverInterface
{
    protected $_observer;

    /**
     * @param \Bronto\Balance\Model\Observer
     */
    public function __construct(
        \Bronto\Balance\Model\Observer $observer
    ) {
        $this->_observer = $observer;
    }
}
