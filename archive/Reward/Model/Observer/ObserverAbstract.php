<?php

namespace Bronto\Reward\Model\Observer;

abstract class ObserverAbstract implements \Magento\Framework\Event\ObserverInterface
{
    protected $_observer;

    /**
     * @param \Bronto\Reward\Model\Observer
     */
    public function __construct(
        \Bronto\Reward\Model\Observer $observer
    ) {
        $this->_observer = $observer;
    }
}
