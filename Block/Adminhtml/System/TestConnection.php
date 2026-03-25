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

namespace MageMe\WebFormsZendesk\Block\Adminhtml\System;

use Exception;
use MageMe\WebFormsZendesk\Helper\ScopeHelper;
use MageMe\WebFormsZendesk\Helper\ZendeskHelper;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;

class TestConnection extends Field
{
    const BUTTON_LABEL = 'button_label';
    const HTML_ID = 'html_id';
    const AJAX_URL = 'ajax_url';
    const ZENDESK_CONFIGURED = 'zendesk_configured';

    /**
     * @var ZendeskHelper
     */
    private $zendeskHelper;
    /**
     * @var ScopeHelper
     */
    private $scopeHelper;

    /**
     * @param ScopeHelper $scopeHelper
     * @param ZendeskHelper $zendeskHelper
     * @param Context $context
     * @param array $data
     */
    public function __construct(ScopeHelper $scopeHelper,
        ZendeskHelper $zendeskHelper, Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->zendeskHelper = $zendeskHelper;
        $this->scopeHelper = $scopeHelper;
    }

    /**
     * Set template
     *
     * {@inheritdoc}
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->setTemplate('MageMe_WebFormsZendesk::system/testconnection.phtml');
        return $this;
    }

    /**
     * Unset irrelevant element data
     *
     * @inheritdoc
     * @noinspection PhpUndefinedMethodInspection
     */
    public function render(AbstractElement $element): string
    {
        $element = clone $element;
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Get element output
     *
     * @inheritdoc
     * @throws NoSuchEntityException
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $storeId = $this->scopeHelper->getStoreConfigScopeStoreId($this->getRequest());

        $isConfigured = false;

        try {
            $this->zendeskHelper->validateConfiguration(
                ScopeInterface::SCOPE_STORE,
                $storeId
            );
            $isConfigured = true;
        } catch (Exception $exception) {
            // zendesk integration must not be configured.
        }

        /** @noinspection PhpUndefinedMethodInspection */
        $originalData = $element->getOriginalData();
        $this->addData(
            [
                self::BUTTON_LABEL => __($originalData['button_label']),
                self::HTML_ID => $element->getHtmlId(),
                self::AJAX_URL => $this->_urlBuilder->getUrl('webformszendesk/system/testconnection'),
                self::ZENDESK_CONFIGURED => $isConfigured
            ]
        );

        return $this->_toHtml();
    }

    /**
     * @return mixed
     */
    public function getButtonLabel() {
        return $this->getData(self::BUTTON_LABEL);
    }

    /**
     * @return mixed
     */
    public function getHtmlId() {
        return $this->getData(self::HTML_ID);
    }

    /**
     * @return mixed
     */
    public function getAjaxUrl() {
        return $this->getData(self::AJAX_URL);
    }

    /**
     * @return mixed
     */
    public function getZendeskConfigured() {
        return $this->getData(self::ZENDESK_CONFIGURED);
    }
}
