<?php

namespace Bronto\M2\Reward;

class Settings implements \Bronto\M2\Contact\AttributeSettingsInterface
{
    public static $_fields = [
        'reward_points' => ['name' => 'Reward Points', 'type' => 'integer'],
        'reward_points_currency' => ['name' => 'Reward Currency', 'type' => 'float'],
        'reward_points_dollars' => ['name' => 'Reward Currency Formatted', 'type' => 'text']
    ];

    public static $_methods = [
        'getPointsBalance',
        'getCurrencyAmount',
        'getFormatedCurrencyAmount'
    ];

    protected $_storeManager;
    protected $_rewards;

    /**
     * @param \Bronto\M2\Core\Store\ManagerInterface $storeManager
     * @param \Bronto\M2\Reward\ManagerInterface $rewards
     */
    public function __construct(
        \Bronto\M2\Core\Store\ManagerInterface $storeManager,
        \Bronto\M2\Reward\ManagerInterface $rewards
    ) {
        $this->_storeManager = $storeManager;
        $this->_rewards = $rewards;
    }

    /**
     * @see parent
     */
    public function getFields()
    {
        return self::$_fields;
    }

    /**
     * @see parent
     */
    public function getExtra($contact, $storeId = null)
    {
        $store = $this->_storeManager->getStore($storeId);
        $reward = $this->_rewards->getByCustomer($contact->getId(), $store->getWebsiteId());
        $defaults = [];
        foreach ($this->_methods() as $fieldId => $methodName) {
            $defaults[$fieldId] = '';
            if ($reward) {
                $defaults[$fieldId] = call_user_func([$reward, $methodName]);
            }
        }
        return $defaults;
    }

    /**
     * Gets field mapping to methods
     *
     * @return array
     */
    protected function _methods()
    {
        return array_combine(array_keys($this->getFields()), self::$_methods);
    }
}
