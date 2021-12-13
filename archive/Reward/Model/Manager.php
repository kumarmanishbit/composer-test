<?php

namespace Bronto\Reward\Model;

class Manager implements \Bronto\M2\Reward\ManagerInterface
{
    protected $_rewardFactory;

    /**
     * @param \Magento\Reward\Model\RewardFactory $rewardFactory
     */
    public function __construct(
        \Magento\Reward\Model\RewardFactory $rewardFactory
    ) {
        $this->_rewardFactory = $rewardFactory;
    }

    /**
     * @see parent
     */
    public function getByCustomer($customerId, $websiteId)
    {
        $reward = $this->_rewardFactory->create()
            ->setCustomerId($customerId)
            ->setWebsiteId($websiteId)
            ->loadByCustomer();
        if ($reward->getId()) {
            return $reward;
        }
        return null;
    }
}
