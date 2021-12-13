<?php

namespace Bronto\M2\Balance;

class Settings implements \Bronto\M2\Contact\AttributeSettingsInterface
{
    public static $_fields = [
        'store_credit_currency' => ['name' => 'Store Credit', 'type' => 'float'],
        'store_credit' => ['name' => 'Store Credit Formatted', 'type' => 'text']
    ];

    public static $_formatOptions = [
        'store_credit_currency' => ['display' => 1, 'precision' => 2],
        'store_credit' => ['display' => 2, 'precision' => 2]
    ];

    protected $_storeManager;
    protected $_credits;

    /**
     * @param \Bronto\M2\Core\Store\ManagerInterface $storeManager
     * @param \Bronto\M2\Balance\ManagerInterface $credits
     */
    public function __construct(
        \Bronto\M2\Core\Store\ManagerInterface $storeManager,
        \Bronto\M2\Balance\ManagerInterface $credits
    ) {
        $this->_storeManager = $storeManager;
        $this->_credits = $credits;
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
        $currency = $store->getWebsite()->getBaseCurrency();
        $credit = $this->_credits->getByCustomer($contact->getId(), $store->getWebsiteId());
        $return = [];
        foreach ($this->getFields() as $fieldId => $fieldLabel) {
            $return[$fieldId] = '';
            if ($credit) {
                $options = self::$_formatOptions[$fieldId];
                $return[$fieldId] = $currency->formatTxt($credit->getAmount(), $options);
            }
        }
        return $return;
    }
}
