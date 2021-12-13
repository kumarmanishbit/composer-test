<?php

namespace Bronto\Reward\Model;

class Observer extends \Bronto\M2\Contact\AttributeExtensionAbstract
{
    /**
     * @param \Bronto\M2\Reward\Settings $settings
     */
    public function __construct(
        \Bronto\M2\Reward\Settings $settings
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
