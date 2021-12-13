<?php

namespace Bronto\Balance\Model;

class Manager implements \Bronto\M2\Balance\ManagerInterface
{
    protected $_creditFactory;

    /**
     * @param \Magento\CustomerBalance\Model\BalanceFactory $creditFactory
     */
    public function __construct(
        \Magento\CustomerBalance\Model\BalanceFactory $creditFactory
    ) {
        $this->_creditFactory = $creditFactory;
    }

    /**
     * @see parent
     */
    public function getByCustomer($customerId, $websiteId)
    {
        $credit = $this->_creditFactory->create()
            ->setCustomerId($customerId)
            ->setWebsiteId($websiteId)
            ->loadByCustomer();
        if ($credit->getId()) {
            return $credit;
        }
        return null;
    }
}
