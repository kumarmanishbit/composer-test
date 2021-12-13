<?php

namespace Bronto\Reward\Model\Observer;

class AfterContactAdditionalObserver extends ObserverAbstract
{
    /**
     * @see parent
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->_observer->contactAdditional($observer);
    }
}
