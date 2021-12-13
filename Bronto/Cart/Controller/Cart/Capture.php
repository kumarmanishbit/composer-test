<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Cart\Controller\Cart;

class Capture extends \Magento\Framework\App\Action\Action
{
    protected $_settings;
    protected $_logger;

    /** @var \Bronto\M2\Core\Sales\CheckoutSessionInterface */
    protected $checkout;

    /**
     * @param \Bronto\M2\Cart\SettingsInterface $settings
     * @param \Bronto\M2\Core\Log\LoggerInterface $logger
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Bronto\M2\Cart\SettingsInterface $settings,
        \Bronto\M2\Core\Sales\CheckoutSessionInterface $checkout,
        \Bronto\M2\Core\Log\LoggerInterface $logger,
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->_settings = $settings;
        $this->checkout = $checkout;
        $this->_logger = $logger;
    }

    /**
     * @see parent
     */
    public function execute()
    {
// GET /import

        /// This will help to get the current request data.
        /// // $this->getRequest()->getPost(). will give us post request data.
        /// $this->getRequest()->getParams() will give us get request data.
        /// // someone is making a http get call to this guy.
        ///
        $emailAddress = $this->getRequest()->getParam('emailAddress', null);
        try {
            $this->_settings->setCartRecoveryCookie($emailAddress);
            if ($this->isQuoteActive()) {
                $this->_eventManager->dispatch('bronto_checkout_email_capture', [
                    'quote' => $this->checkout->getQuote()
                        ->setCustomerEmail($emailAddress)
                        ->setUpdatedAt(date('c'))
                ]);
            }
        } catch (\Exception $e) {
            $this->_logger->critical($e);
        }
        return $this->getResponse();
    }

    /**
     * @return bool
     */
    private function isQuoteActive()
    {
        return (
            $this->checkout->getQuoteId() &&
            $this->checkout->getQuote()->getIsActive()
        );
    }
}
