<?php
/**
 * MageMe
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageMe.com license that is
 * available through the world-wide-web at this URL:
 * https://mageme.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to a newer
 * version in the future.
 *
 * Copyright (c) MageMe (https://mageme.com)
 **/

namespace MageMe\WebFormsZendesk\Model\Field\Type;

use MageMe\WebForms\Api\Ui\FieldUiInterface;
use MageMe\WebForms\Api\Utility\Field\FieldBlockInterface;
use MageMe\WebForms\Model\Field\Context;
use MageMe\WebFormsZendesk\Config\Options\Type;

class ZendeskType extends AbstractZendeskSelect
{
    /**
     * @var Type
     */
    private $zendeskType;

    /**
     * @param Type $zendeskType
     * @param Context $context
     * @param FieldUiInterface $fieldUi
     * @param FieldBlockInterface $fieldBlock
     */
    public function __construct(
        Type $zendeskType,
        Context $context,
        FieldUiInterface $fieldUi,
        FieldBlockInterface $fieldBlock
    ) {
        parent::__construct($context, $fieldUi, $fieldBlock);
        $this->zendeskType = $zendeskType;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        return $this->zendeskType->toOptionArray();
    }
}
