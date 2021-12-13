<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Controller\Adminhtml;

abstract class Connector extends \Magento\Backend\App\Action
{
    const AUTHORIZATION = "X-Authorization";

    protected $_encoder;
    protected $_encrypt;
    protected $_connector;
    protected $_middleware;
    protected $_logger;

    /** @var  \Bronto\M2\Helper\Data $mageHelper */
    protected $mageHelper;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Bronto\Serialize\BiDirectional $encoder
     * @param \Magento\Framework\Encryption\EncryptorInterface $encrypt
     * @param \Bronto\Connector\Model\ConnectorInterface $connector
     * @param \Bronto\Connector\Model\MiddlewareInterface $middleware
     * @param \Bronto\M2\Helper\Data $mageHelper,
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Bronto\Serialize\BiDirectional $encoder,
        \Magento\Framework\Encryption\EncryptorInterface $encrypt,
        \Bronto\M2\Connector\ConnectorInterface $connector,
        \Bronto\M2\Connector\MiddlewareInterface $middleware,
        \Bronto\M2\Helper\Data $mageHelper,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->_encoder = $encoder;
        $this->_encrypt = $encrypt;
        $this->_connector = $connector;
        $this->_middleware = $middleware;
        $this->_logger = $logger;
        $this->mageHelper = $mageHelper;
    }

    /**
     * Implementors will handle the guarded action
     *
     * @param \Bronto\Connector\Model\Registration $registration
     * @return mixed
     */
    abstract protected function _execute($registration);

    /**
     * @see parent
     */
    public function execute()
    {
        // Registers a callback to be executed after script execution finishes or exit() is called.
        register_shutdown_function(["Bronto\Connector\Helper\Data", "fatalErrorHandler"], $this->_logger);
        $json = [];
        $encryptedId = $this->getRequest()->getHeader(self::AUTHORIZATION);
        $this->logRequest();
        try {
            if ($encryptedId) {
                $decryptedAuth = explode('.', $this->_decryptId($encryptedId));
                if (2 == count($decryptedAuth)) {
                    list($scopeType, $scopeId) = $decryptedAuth;
                    $registration = $this->_objectManager
                        ->create('Bronto\Connector\Model\Registration')
                        ->loadByScope($scopeType, $scopeId);
                    if ($registration->getId()) {
                        $json = $this->_execute($registration);
                    } else {
                        $json['message'] = 'The registration does not exist.';
                        $json['code'] = 404;
                    }
                } else {
                    $json['message'] = 'Invalid authorization';
                    $json['code'] = 401;
                }
            } else {
                $json['message'] = 'Authorization header missing.';
                $json['code'] = 401;
            }
        } catch (\Exception $e) {
            $this->_logger->critical('Action: '
                . get_class($this)
                . ' failed: '
                . $e->getMessage());
            $json['message'] = $e->getMessage();
            $json['code'] = 500;
        }
        $this->_logger->debug("Response start");
        $this->_logger->debug(json_encode($json));
        $this->_logger->debug("Response end");
        return $this->getResponse()
            ->setHeader("Content-Type", $this->_encoder->getMimeType())
            ->setHttpResponseCode(array_key_exists('code', $json) ? $json['code'] : 200)
            ->setBody($this->_encoder->encode($json));
    }

    /**
     * Unwind the connector key
     *
     * @param string $encryptedId
     * @return string
     */
    protected function _decryptId($encryptedId)
    {
        return $this->_encrypt->decrypt(rawurldecode($encryptedId));
    }

    /**
     * @see parent
     */
    protected function _isAllowed()
    {
        return true;
    }

    /**
     * Logs the request data if debugging in enabled
     */
    protected function logRequest()
    {
        $fidString = $this->mageHelper->getFireInstanceIdString();
        $this->_logger->debug(
            get_class($this->getRequest()) . "\n" .
            "-------------------------------------------------------------"
            . "\nBRONTO REQUEST DATA START {$fidString}"
            . "\n-------------------------------------------------------------"
            . "\nMETHOD: {$this->getRequest()->getMethod()}"
            . "\nPATH: {$this->getRequest()->getActionName()}"
            . "\nPARAMS: " . var_export($this->getRequest()->getParams(), true)
            . "\nPAYLOAD: " . $this->getRequest()->getContent()
            . "\nPOST PAYLOAD: " . var_export($this->getRequest()->getPost(), true)
            . "\n-------------------------------------------------------------"
            . "\nBRONTO REQUEST DATA END {$fidString}"
            . "\n-------------------------------------------------------------"
        );
    }
}
