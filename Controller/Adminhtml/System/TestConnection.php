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

namespace MageMe\WebFormsZendesk\Controller\Adminhtml\System;

use Exception;
use MageMe\WebFormsZendesk\Helper\ZendeskHelper;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Filter\StripTags;
use Magento\Store\Model\ScopeInterface;
use Zendesk\API\Exceptions\AuthException;

class TestConnection extends Action
{
    /**
     * @inheritdoc
     */
    const ADMIN_RESOURCE = 'MageMe_WebForms::settings';
    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;
    /**
     * @var StripTags
     */
    private $tagFilter;
    /**
     * @var ZendeskHelper
     */
    private $zendeskHelper;

    /**
     * @param ZendeskHelper $zendeskHelper
     * @param StripTags $tagFilter
     * @param JsonFactory $resultJsonFactory
     * @param Context $context
     */
    public function __construct(
        ZendeskHelper $zendeskHelper,
        StripTags     $tagFilter,
        JsonFactory   $resultJsonFactory,
        Context       $context
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->tagFilter         = $tagFilter;
        $this->zendeskHelper     = $zendeskHelper;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $result = [
            'success' => false,
            'errorMessage' => '',
        ];
        try {
            $storeId = (int)$this->getRequest()->getParam('scope');
            $this->zendeskHelper->getApi(true, ScopeInterface::SCOPE_STORE, $storeId)->checkCredentials();
            $result['success'] = true;
        } catch (AuthException $e) {
            $result['errorMessage'] = $e->getMessage();
        } catch (Exception $e) {
            $message                = __($e->getMessage());
            $result['errorMessage'] = $this->tagFilter->filter($message);
        }

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($result);
    }
}
