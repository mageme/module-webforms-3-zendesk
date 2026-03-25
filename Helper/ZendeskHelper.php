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

namespace MageMe\WebFormsZendesk\Helper;

use InvalidArgumentException;
use MageMe\WebFormsZendesk\Helper\Zendesk\Api;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Zendesk\API\Exceptions\AuthException;

class ZendeskHelper
{
    const CONFIG_DOMAIN = 'webforms/zendesk/domain';
    const CONFIG_EMAIL = 'webforms/zendesk/email';
    const CONFIG_TOKEN = 'webforms/zendesk/token';
    const ZENDESK_DOMAIN = '.zendesk.com';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var Api
     */
    private $api;

    /**
     * @param Api $api
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(Api $api, ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
        $this->api         = $api
            ->setAuthSubdomain($this->getConfigSubDomain())
            ->setAuthEmail($this->getConfigEmail())
            ->setAuthToken($this->getConfigToken())
            ->setScope(ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
    }

    /**
     * @param bool $validateConfig
     * @param string $scopeType
     * @param null|int|string $scopeCode
     * @return Api
     * @throws AuthException
     */
    public function getApi(
        bool   $validateConfig = true,
        string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
               $scopeCode = null
    ): Api {
        if ($validateConfig) {
            $this->validateConfiguration($scopeType, $scopeCode);
        }
        $scope = $scopeType . $scopeCode;
        if ($this->api->getScope() === $scope) {
            return $this->api;
        }
        $this->api
            ->setAuthSubdomain($this->getConfigSubDomain($scopeType, $scopeCode))
            ->setAuthEmail($this->getConfigEmail($scopeType, $scopeCode))
            ->setAuthToken($this->getConfigToken($scopeType, $scopeCode));
        $this->api->initApi();
        $this->api->setScope($scope);
        return $this->api;
    }

    /**
     * @param string $scopeType
     * @param null|int|string $scopeCode
     */
    public function validateConfiguration(
        string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
               $scopeCode = null
    ) {
        if (empty($this->getConfigDomain($scopeType, $scopeCode))) {
            throw new InvalidArgumentException(__('Zendesk domain not configured.'));
        }
        if (empty($this->getConfigEmail($scopeType, $scopeCode))) {
            throw new InvalidArgumentException(__('Zendesk agent email not configured.'));
        }
        if (empty($this->getConfigToken($scopeType, $scopeCode))) {
            throw new InvalidArgumentException(__('Zendesk API token not configured.'));
        }
    }

    /**
     * @param string $scopeType
     * @param null|int|string $scopeCode
     * @return mixed
     */
    protected function getConfigDomain(string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        return $this->scopeConfig->getValue(self::CONFIG_DOMAIN, $scopeType, $scopeCode);
    }

    /**
     * @param string $scopeType
     * @param null|int|string $scopeCode
     * @return string
     */
    protected function getConfigSubDomain(
        string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
               $scopeCode = null
    ): string {
        $domain = (string)$this->getConfigDomain($scopeType, $scopeCode);
        return str_replace(self::ZENDESK_DOMAIN, '', $domain);
    }

    /**
     * @param string $scopeType
     * @param null|int|string $scopeCode
     * @return mixed
     */
    protected function getConfigEmail(string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        return (string)$this->scopeConfig->getValue(self::CONFIG_EMAIL, $scopeType, $scopeCode);
    }

    /**
     * @param string $scopeType
     * @param null|int|string $scopeCode
     * @return mixed
     */
    protected function getConfigToken(string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        return $this->scopeConfig->getValue(self::CONFIG_TOKEN, $scopeType, $scopeCode);
    }
}
