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

namespace MageMe\WebFormsZendesk\Api\Data;

interface FormInterface extends \MageMe\WebForms\Api\Data\FormInterface
{
    /** Zendesk settings */
    const IS_ZENDESK_ENABLED = 'is_zendesk_enabled';
    const ZENDESK_EMAIL_FIELD_ID = 'zendesk_email_field_id';
    const ZENDESK_GROUP = 'zendesk_group';
    const ZENDESK_PRIORITY = 'zendesk_priority';
    const ZENDESK_TYPE = 'zendesk_type';
    const ZENDESK_FOLLOWERS_SERIALIZED = 'zendesk_followers_serialized';
    const ZENDESK_TAGS = 'zendesk_tags';
    const ZENDESK_MAP_FIELDS_SERIALIZED = 'zendesk_map_fields_serialized';

    /**
     * Additional constants for keys of data array.
     */
    const ZENDESK_FOLLOWERS = 'zendesk_followers';
    const ZENDESK_MAP_FIELDS = 'zendesk_map_fields';

    #region Zendesk

    /**
     * Get isZendeskEnabled
     *
     * @return bool
     */
    public function getIsZendeskEnabled(): bool;

    /**
     * Set isZendeskEnabled
     *
     * @param bool $isZendeskEnabled
     * @return $this
     */
    public function setIsZendeskEnabled(bool $isZendeskEnabled): FormInterface;

    /**
     * Get zendeskEmailFieldId
     *
     * @return int|null
     */
    public function getZendeskEmailFieldId(): ?int;

    /**
     * Set zendeskEmailFieldId
     *
     * @param int|null $zendeskEmailFieldId
     * @return $this
     */
    public function setZendeskEmailFieldId(?int $zendeskEmailFieldId): FormInterface;

    /**
     * Get zendeskGroup
     *
     * @return string|null
     */
    public function getZendeskGroup(): ?string;

    /**
     * Set zendeskGroup
     *
     * @param string $zendeskGroup
     * @return $this
     */
    public function setZendeskGroup(string $zendeskGroup): FormInterface;

    /**
     * Get zendeskPriority
     *
     * @return string|null
     */
    public function getZendeskPriority(): ?string;

    /**
     * Set zendeskPriority
     *
     * @param string $zendeskPriority
     * @return $this
     */
    public function setZendeskPriority(string $zendeskPriority): FormInterface;

    /**
     * Get zendeskType
     *
     * @return string|null
     */
    public function getZendeskType(): ?string;

    /**
     * Set zendeskType
     *
     * @param string $zendeskType
     * @return $this
     */
    public function setZendeskType(string $zendeskType): FormInterface;

    /**
     * Get zendeskFollowers
     *
     * @return string|null
     */
    public function getZendeskFollowersSerialized(): ?string;

    /**
     * Set zendeskFollowers
     *
     * @param string $zendeskFollowersSerialized
     * @return $this
     */
    public function setZendeskFollowersSerialized(string $zendeskFollowersSerialized): FormInterface;

    /**
     * Get zendeskTags
     *
     * @return string|null
     */
    public function getZendeskTags(): ?string;

    /**
     * Set zendeskTags
     *
     * @param string $zendeskTags
     * @return $this
     */
    public function setZendeskTags(string $zendeskTags): FormInterface;

    /**
     * Get zendeskFollowers
     *
     * @return array
     */
    public function getZendeskFollowers(): array;

    /**
     * Set zendeskFollowers
     *
     * @param array $zendeskFollowers
     * @return $this
     */
    public function setZendeskFollowers(array $zendeskFollowers): FormInterface;

    /**
     * Get zendeskMapFieldsSerialized
     *
     * @return string|null
     */
    public function getZendeskMapFieldsSerialized(): ?string;

    /**
     * Set zendeskMapFieldsSerialized
     *
     * @param string $zendeskMapFieldsSerialized
     * @return $this
     */
    public function setZendeskMapFieldsSerialized(string $zendeskMapFieldsSerialized): FormInterface;

    /**
     * Get zendeskMapFields
     *
     * @return array
     */
    public function getZendeskMapFields(): array;

    /**
     * Set zendeskMapFields
     *
     * @param array $zendeskMapFields
     * @return $this
     */
    public function setZendeskMapFields(array $zendeskMapFields): FormInterface;
    #endregion
}
