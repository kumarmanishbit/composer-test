<?php
/*
 * Copyright © 2021, Oracle and/or its affiliates. All rights reserved.
 *
 * Licensed under the Universal Permissive License v 1.0 as shown at https://oss.oracle.com/licenses/upl.
 */

namespace Bronto\Connector\Block\Adminhtml\Registration\Grid\Renderer;

class Action extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\Action
{
    /**
     * @see parent
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        $actions = [];
        $actions[] = [
            'url' => $this->getUrl('*/*/edit', ['id' => $row->getId()]),
            'caption' => __('Edit')
        ];
        $actions[] = [
            'url' => $this->getUrl('*/*/delete', ['id' => $row->getId()]),
            'caption' => __('Delete'),
        ];
        $actions[] = [
            'url' => $this->getUrl('*/*/settings', ['id' => $row->getId()]),
            'caption' => __('Sync Settings'),
        ];
        if (!$row->getIsActive()) {
            $actions[] = [
               'url' => $this->getUrl('*/*/register', ['id' => $row->getId()]),
               'caption' => __('Register')
            ];
        }
        $this->getColumn()->setActions($actions);
        return parent::render($row);
    }
}
