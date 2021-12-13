<?php

namespace Bronto\Reward\Model\Observer;

class AfterContactLoadFieldsObserver extends ObserverAbstract
{
    /**
     * @see parent
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->_observer->contactLoadFields($observer);
    }
}
