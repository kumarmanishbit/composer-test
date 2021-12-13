<?php

namespace Bronto\Balance\Model;

class Observer extends \Bronto\M2\Contact\AttributeExtensionAbstract
{
    /**
     * @param \Bronto\M2\Balance\Settings $settings
     */
    public function __construct(
        \Bronto\M2\Balance\Settings $settings
    ) {
        parent::__construct($settings);
    }

    /**
     * @see parent
     */
    public function translate($message)
    {
        return __($message);
    }
}
