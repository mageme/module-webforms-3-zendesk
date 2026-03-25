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

use MageMe\WebForms\Model\Field\AbstractField;
use Magento\Framework\Data\OptionSourceInterface;

abstract class AbstractZendeskSelect extends AbstractField implements OptionSourceInterface
{
    /**
     * @inheritDoc
     * @noinspection DuplicatedCode
     */
    public function getValidation(): array
    {
        $validation = parent::getValidation();
        if ($this->getIsRequired()) {
            unset($validation['rules']['required-entry']);
            $validation['rules']['validate-select'] = "'validate-select':true";
            if ($this->getValidationRequiredMessage()) {
                unset($validation['descriptions']['data-msg-required-entry']);
                $validation['descriptions']['data-msg-validate-select'] = $this->getValidationRequiredMessage();
            }
        }
        return $validation;
    }

    /**
     * @param array $options
     * @inheritDoc
     */
    public function getValueForResultTemplate($value, ?int $resultId = null, array $options = [])
    {
        $values = is_array($value) ? $value : explode("\n", (string)$value);
        $arr = [];
        foreach ($values as $item) {
            $label = $this->getOptionLabel($item);
            if ($label) {
                $arr[] = $label;
            }
        }
        return implode("\n", $arr);
    }

    /**
     * @inheritDoc
     */
    public function getValueForResultHtml($value, array $options = [])
    {
        return parent::getValueForResultHtml($this->getValueForResultTemplate($value));
    }

    /**
     * @inheritDoc
     */
    public function getResultCollectionFilterCondition($value, string $prefix = '%'): string
    {
        $id          = $this->getId();
        $searchValue = $this->getResultCollectionFilterConditionSearchValue($value);
        return "results_values_$id.value like '" . $searchValue . "'";
    }

    /**
     * @param string $value
     * @return string
     */
    protected function getOptionLabel(string $value): string
    {
        foreach ($this->toOptionArray() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return '';
    }
}
