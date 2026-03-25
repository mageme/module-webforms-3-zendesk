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

namespace MageMe\WebFormsZendesk\Plugin\MageMe\WebForms\Helper\Result\PostHelper;

use MageMe\WebForms\Api\Data\FormInterface;
use MageMe\WebForms\Api\Data\ResultInterface;
use MageMe\WebForms\Helper\Result\PostHelper;
use MageMe\WebFormsZendesk\Helper\Zendesk\AddTicket;
use Magento\Framework\Exception\NoSuchEntityException;
use Zendesk\API\Exceptions\ApiResponseException;
use Zendesk\API\Exceptions\AuthException;
use Zendesk\API\Exceptions\ResponseException;

class PostResult
{
    /**
     * @var AddTicket
     */
    private $addTicket;

    /**
     * @param AddTicket $addTicket
     */
    public function __construct(
        AddTicket $addTicket
    ) {
        $this->addTicket = $addTicket;
    }

    /**
     * @param PostHelper $postHelper
     * @param array $data
     * @param FormInterface|\MageMe\WebFormsZendesk\Api\Data\FormInterface $form
     * @param array $config
     * @return array
     * @noinspection PhpUnusedParameterInspection
     * @throws NoSuchEntityException
     */
    public function afterPostResult(PostHelper $postHelper, array $data, FormInterface $form, array $config = []): array
    {
        if (!$data['success'] || !($data['model'] instanceof ResultInterface)) {
            return $data;
        }
        $result = $data['model'];
        if ($form->getIsZendeskEnabled()) {
            try {
                $this->addTicket->execute($result);
            } catch (ApiResponseException|AuthException|ResponseException $e) {
            }
        }
        return $data;
    }
}
