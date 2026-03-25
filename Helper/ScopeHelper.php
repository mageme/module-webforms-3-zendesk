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

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Api\GroupRepositoryInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Api\WebsiteRepositoryInterface;

class ScopeHelper extends AbstractHelper
{
    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;
    /**
     * @var GroupRepositoryInterface
     */
    private $storeGroupRepository;
    /**
     * @var WebsiteRepositoryInterface
     */
    private $websiteRepository;

    /**
     * @param StoreRepositoryInterface $storeRepository
     * @param GroupRepositoryInterface $storeGroupRepository
     * @param WebsiteRepositoryInterface $websiteRepository
     * @param Context $context
     */
    public function __construct(
        StoreRepositoryInterface $storeRepository,
        GroupRepositoryInterface $storeGroupRepository,
        WebsiteRepositoryInterface $websiteRepository,
        Context $context
    ) {
        parent::__construct($context);
        $this->storeRepository = $storeRepository;
        $this->storeGroupRepository = $storeGroupRepository;
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * Get default store view of default store group of default website.
     *
     * @return StoreInterface
     * @throws NoSuchEntityException
     */
    public function getDefaultStore(): StoreInterface
    {
        $defaultWebsite = $this->websiteRepository->getDefault();
        $defaultStoreGroup = $this->storeGroupRepository->get($defaultWebsite->getDefaultGroupId());
        return $this->storeRepository->getById($defaultStoreGroup->getDefaultStoreId());
    }

    /**
     * Get store ID of current store config request scope,
     * or default if not applicable.
     *
     * @param RequestInterface $request
     * @return int
     * @throws NoSuchEntityException
     */
    public function getStoreConfigScopeStoreId(RequestInterface $request): int
    {
        // Get website corresponding to currently selected scope.
        $websiteId = $request->getParam('website');
        $website = $websiteId !== null ? $this->websiteRepository->getById($websiteId)
            : $this->websiteRepository->getDefault();

        // Get store corresponding to currently selected scope, or website's default store view if none selected.
        return $request->getParam(
            'store',
            // default to website's default store group's default store's ID
            $this->storeGroupRepository->get($website->getDefaultGroupId())->getDefaultStoreId()
        );
    }

}
