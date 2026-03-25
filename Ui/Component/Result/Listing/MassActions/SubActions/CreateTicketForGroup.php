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

namespace MageMe\WebFormsZendesk\Ui\Component\Result\Listing\MassActions\SubActions;

use MageMe\WebFormsZendesk\Config\Options\Groups;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Action;

class CreateTicketForGroup extends Action
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;
    /**
     * @var Groups
     */
    private $zendeskGroups;

    /**
     * @param Groups $zendeskGroups
     * @param UrlInterface $urlBuilder
     * @param ContextInterface $context
     * @param array $components
     * @param array $data
     * @param null $actions
     */
    public function __construct(
        Groups           $zendeskGroups,
        UrlInterface     $urlBuilder,
        ContextInterface $context,
        array            $components = [],
        array            $data = [],
                         $actions = null
    ) {
        parent::__construct($context, $components, $data, $actions);
        $this->urlBuilder    = $urlBuilder;
        $this->zendeskGroups = $zendeskGroups;
    }

    /**
     * @inheritDoc
     */
    public function prepare()
    {
        $actions = [];
        $groups  = $this->zendeskGroups->toOptionArray();
        foreach ($groups as $group) {
            $name      = $group['label'];
            $id        = $group['value'];
            $actions[] = [
                'type' => $name,
                'label' => $name,
                'url' => $this->urlBuilder->getUrl(
                    'webformszendesk/result/ajaxCreateTicketForGroup',
                    ['group_id' => $id]
                ),
                'isAjax' => true,
                'confirm' => [
                    'title' => __('Create Ticket'),
                    'message' => __('Are you sure?'),
                    '__disableTmpl' => true,
                ],
            ];
        }
        $this->actions = $actions;
        parent::prepare();
    }

}
