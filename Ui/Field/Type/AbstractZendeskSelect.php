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

namespace MageMe\WebFormsZendesk\Ui\Field\Type;

use MageMe\WebForms\Api\Data\ResultInterface;
use MageMe\WebForms\Api\Ui\FieldResultFormInterface;
use MageMe\WebForms\Api\Ui\FieldResultListingColumnInterface;
use MageMe\WebForms\Ui\Component\Common\Listing\Constants\BodyTmpl;
use MageMe\WebForms\Ui\Component\Common\Listing\Constants\Filter;
use MageMe\WebForms\Ui\Field\AbstractField;

abstract class AbstractZendeskSelect extends AbstractField implements FieldResultListingColumnInterface, FieldResultFormInterface
{
    /**
     * @inheritDoc
     */
    public function getResultListingColumnConfig(int $sortOrder): array
    {
        $config             = $this->getDefaultUIResultColumnConfig($sortOrder);
        $config['filter']   = Filter::SELECT;
        $config['options']  = $this->getField()->toOptionArray();
        $config['bodyTmpl'] = BodyTmpl::HTML;
        return $config;
    }

    /**
     * @inheritDoc
     */
    public function getResultAdminFormConfig(?ResultInterface $result = null): array
    {
        $config           = $this->getDefaultResultAdminFormConfig();
        $config['type']   = 'select';
        $config['values'] = $this->getField()->toOptionArray();
        return $config;
    }
}
