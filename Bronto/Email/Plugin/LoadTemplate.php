<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Email\Plugin;

class LoadTemplate
{
    protected $_helper;
    protected $_templateFactory;

    /**
     * @param \Bronto\M2\Email\SettingsInterface $helper
     * @param \Bronto\Email\Model\TemplateFactory $templateFactory
     */
    public function __construct(
        \Bronto\M2\Email\SettingsInterface $helper,
        \Bronto\Email\Model\TemplateFactory $templateFactory
    ) {
        $this->_helper = $helper;
        $this->_templateFactory = $templateFactory;
    }

    /**
     * Creates a Bronto Template if provided, or fallback to existing
     *
     * @param mixed $subject
     * @param callable $get
     * @param mixed $templateId
     */
    public function aroundGet($subject, $get, $templateId, $namespace = null)
    {
        // Replaces initial workflow with injected workflow.
        // It's not yet possible to know which context should
        // be loaded, so that logic is passed to the Template
        $lookup = $this->_helper->getLookup($templateId);
        if (!empty($lookup)) {
            return $this->_templateFactory->create([ 'originalId' => $templateId ]);
        }
        return $get($templateId, $namespace);
    }
}