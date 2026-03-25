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

namespace MageMe\WebFormsZendesk\Config\Options;

use Magento\Framework\Data\OptionSourceInterface;

class Priority implements OptionSourceInterface
{
    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        return [
            [
                'label' => __('Low'),
                'value' => 'low',
            ],
            [
                'label' => __('Normal'),
                'value' => 'normal',
            ],
            [
                'label' => __('High'),
                'value' => 'high',
            ],
            [
                'label' => __('Urgent'),
                'value' => 'urgent',
            ],
        ];
    }

}
