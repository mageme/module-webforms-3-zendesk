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

namespace MageMe\WebFormsZendesk\Model;

use MageMe\WebFormsZendesk\Api\Data\FormInterface;

class Form extends \MageMe\WebForms\Model\Form implements FormInterface
{
    #region DB getters and setters
    /**
     * @inheritDoc
     */
    public function getIsZendeskEnabled(): bool
    {
        return (bool)$this->getData(self::IS_ZENDESK_ENABLED);
    }

    /**
     * @inheritDoc
     */
    public function setIsZendeskEnabled(bool $isZendeskEnabled): FormInterface
    {
        return $this->setData(self::IS_ZENDESK_ENABLED, $isZendeskEnabled);
    }

    /**
     * @inheritDoc
     */
    public function getZendeskEmailFieldId(): ?int
    {
        return $this->getData(self::ZENDESK_EMAIL_FIELD_ID);
    }

    /**
     * @inheritDoc
     */
    public function setZendeskEmailFieldId(?int $zendeskEmailFieldId): FormInterface
    {
        return $this->setData(self::ZENDESK_EMAIL_FIELD_ID, $zendeskEmailFieldId);
    }

    /**
     * @inheritDoc
     */
    public function getZendeskGroup(): ?string
    {
        return $this->getData(self::ZENDESK_GROUP);
    }

    /**
     * @inheritDoc
     */
    public function setZendeskGroup(string $zendeskGroup): FormInterface
    {
        return $this->setData(self::ZENDESK_GROUP, $zendeskGroup);
    }

    /**
     * @inheritDoc
     */
    public function getZendeskPriority(): ?string
    {
        return $this->getData(self::ZENDESK_PRIORITY);
    }

    /**
     * @inheritDoc
     */
    public function setZendeskPriority(string $zendeskPriority): FormInterface
    {
        return $this->setData(self::ZENDESK_PRIORITY, $zendeskPriority);
    }

    /**
     * @inheritDoc
     */
    public function getZendeskType(): ?string
    {
        return $this->getData(self::ZENDESK_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setZendeskType(string $zendeskType): FormInterface
    {
        return $this->setData(self::ZENDESK_TYPE, $zendeskType);
    }

    /**
     * @inheritDoc
     */
    public function getZendeskFollowersSerialized(): ?string
    {
        return $this->getData(self::ZENDESK_FOLLOWERS_SERIALIZED);
    }

    /**
     * @inheritDoc
     */
    public function setZendeskFollowersSerialized(string $zendeskFollowersSerialized): FormInterface
    {
        return $this->setData(self::ZENDESK_FOLLOWERS_SERIALIZED, $zendeskFollowersSerialized);
    }

    /**
     * @inheritDoc
     */
    public function getZendeskTags(): ?string
    {
        return $this->getData(self::ZENDESK_TAGS);
    }

    /**
     * @inheritDoc
     */
    public function setZendeskTags(string $zendeskTags): FormInterface
    {
        return $this->setData(self::ZENDESK_TAGS, $zendeskTags);
    }

    /**
     * @inheritDoc
     */
    public function getZendeskFollowers(): array
    {
        $data = $this->getData(self::ZENDESK_FOLLOWERS);
        return is_array($data) ? $data : [];
    }

    /**
     * @inheritDoc
     */
    public function setZendeskFollowers(array $zendeskFollowers): FormInterface
    {
        return $this->setData(self::ZENDESK_FOLLOWERS, $zendeskFollowers);
    }

    /**
     * @inheritDoc
     */
    public function getZendeskMapFieldsSerialized(): ?string
    {
        return $this->getData(self::ZENDESK_MAP_FIELDS_SERIALIZED);
    }

    /**
     * @inheritDoc
     */
    public function setZendeskMapFieldsSerialized(string $zendeskMapFieldsSerialized): FormInterface
    {
        return $this->setData(self::ZENDESK_MAP_FIELDS_SERIALIZED, $zendeskMapFieldsSerialized);
    }

    /**
     * @inheritDoc
     */
    public function getZendeskMapFields(): array
    {
        $data = $this->getData(self::ZENDESK_MAP_FIELDS);
        return is_array($data) ? $data : [];
    }

    /**
     * @inheritDoc
     */
    public function setZendeskMapFields(array $zendeskMapFields): FormInterface
    {
        return $this->setData(self::ZENDESK_MAP_FIELDS, $zendeskMapFields);
    }
    #endregion

}
