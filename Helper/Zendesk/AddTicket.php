<?php

namespace MageMe\WebFormsZendesk\Helper\Zendesk;

use Exception;
use MageMe\WebForms\Api\Data\FieldInterface;
use MageMe\WebForms\Api\Data\FileDropzoneInterface;
use MageMe\WebForms\Api\Data\FormInterface as FormInterfaceAlias;
use MageMe\WebForms\Api\Data\ResultInterface;
use MageMe\WebForms\Api\FieldRepositoryInterface;
use MageMe\WebForms\Api\FileGalleryRepositoryInterface;
use MageMe\WebForms\Model\Field\Type\AbstractOption;
use MageMe\WebForms\Model\Field\Type\File;
use MageMe\WebForms\Model\Field\Type\Gallery;
use MageMe\WebFormsZendesk\Api\Data\FormInterface;
use MageMe\WebFormsZendesk\Helper\ZendeskHelper;
use MageMe\WebFormsZendesk\Model\Field\Type\ZendeskGroup;
use MageMe\WebFormsZendesk\Model\Field\Type\ZendeskPriority;
use MageMe\WebFormsZendesk\Model\Field\Type\ZendeskType;
use MageMe\WebFormsZendesk\Ui\Component\Form\Form\Modifier\ZendeskIntegrationSettings;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Zendesk\API\Exceptions\ApiResponseException;
use Zendesk\API\Exceptions\AuthException;
use Zendesk\API\Exceptions\ResponseException;

class AddTicket
{
    /**
     * @var ZendeskHelper
     */
    private $zendeskHelper;
    /**
     * @var FieldRepositoryInterface
     */
    private $fieldRepository;
    /**
     * @var FileGalleryRepositoryInterface
     */
    private $fileGalleryRepository;

    /**
     * @param FileGalleryRepositoryInterface $fileGalleryRepository
     * @param FieldRepositoryInterface $fieldRepository
     * @param ZendeskHelper $zendeskHelper
     */
    public function __construct(
        FileGalleryRepositoryInterface $fileGalleryRepository,
        FieldRepositoryInterface       $fieldRepository,
        ZendeskHelper                  $zendeskHelper
    )
    {
        $this->zendeskHelper         = $zendeskHelper;
        $this->fieldRepository       = $fieldRepository;
        $this->fileGalleryRepository = $fileGalleryRepository;
    }

    /**
     * @param ResultInterface $result
     * @param int|string|null $groupId
     * @return mixed
     * @throws NoSuchEntityException
     * @throws ApiResponseException
     * @throws AuthException
     * @throws ResponseException
     */
    public function execute(ResultInterface $result, $groupId = null)
    {
        /** @var FormInterface $form */
        $form  = $result->getForm();
        $email = $this->getEmail($form, $result);
        if (empty($email)) {
            return null;
        }
        $api = $this->zendeskHelper->getApi(true, ScopeInterface::SCOPE_STORE, $result->getStoreId());
        try {
            $api->checkCredentials();
        } catch (AuthException $e) {
            return null;
        }
        $ticket = [
            'subject'   => $result->getSubject(),
            'comment'   => [
                'html_body' => $result->toHtml(),
            ],
            'requester' => [
                'name'  => $result->getCustomerName(),
                'email' => $email
            ],
        ];
        if ($groupId != null) {
            $ticket['group_id'] = $groupId;
        } else {
            if ($group = $this->getGroup($form, $result)) {
                $ticket['group_id'] = $group;
            }
        }
        if ($priority = $this->getPriority($form, $result)) {
            $ticket['priority'] = $priority;
        }
        if ($type = $this->getType($form, $result)) {
            $ticket['type'] = $type;
        }
        if ($form->getZendeskFollowers()) {
            $ticket['collaborator_ids'] = $form->getZendeskFollowers();
        }
        if ($form->getZendeskTags()) {
            $ticket['tags'] = explode("\n", (string)$form->getZendeskTags());
        }
        $mapFields = $this->mapFields($form, $result);
        $ticket    = array_merge($ticket, $mapFields['ticket']);
        if ($mapFields['files']) {
            $ticket['comment']['uploads'] = $this->getAttachments($mapFields['files'], $api);
        }
        return $api->createTicket($ticket);
    }

    /**
     * @param FormInterface|FormInterfaceAlias $form
     * @param ResultInterface $result
     * @return string
     */
    protected function getEmail(FormInterfaceAlias $form, ResultInterface $result): string
    {
        $values  = $result->getFieldArray();
        $emailId = $form->getZendeskEmailFieldId();
        $email   = $values[$emailId] ?? '';
        if ($email) {
            return $email;
        }
        $emailList = $result->getCustomerEmail();
        return $emailList[0] ?? '';
    }

    /**
     * @param FormInterface|FormInterfaceAlias $form
     * @param ResultInterface $result
     * @return string
     */
    protected function getGroup(FormInterfaceAlias $form, ResultInterface $result): string
    {
        if ($form->getZendeskGroup()) {
            return $form->getZendeskGroup();
        }
        $return = '';
        $values = $result->getFieldArray();
        $fields = $form->getFieldsAsOptions(ZendeskGroup::class, ['with_fieldset' => false]);
        foreach ($fields as $field) {
            if (empty($field['value']) || empty($values[$field['value']])) {
                continue;
            }
            $return = $values[$field['value']];
        }
        return $return ?? '';
    }

    /**
     * @param FormInterface|FormInterfaceAlias $form
     * @param ResultInterface $result
     * @return string
     */
    protected function getPriority(FormInterfaceAlias $form, ResultInterface $result): string
    {
        if ($form->getZendeskPriority()) {
            return $form->getZendeskPriority();
        }
        $return = '';
        $values = $result->getFieldArray();
        $fields = $form->getFieldsAsOptions(ZendeskPriority::class, ['with_fieldset' => false]);
        foreach ($fields as $field) {
            if (empty($field['value']) || empty($values[$field['value']])) {
                continue;
            }
            $return = $values[$field['value']];
        }
        return $return ?? '';
    }

    /**
     * @param FormInterface|FormInterfaceAlias $form
     * @param ResultInterface $result
     * @return string
     */
    protected function getType(FormInterfaceAlias $form, ResultInterface $result): string
    {
        if ($form->getZendeskType()) {
            return $form->getZendeskType();
        }
        $return = '';
        $values = $result->getFieldArray();
        $fields = $form->getFieldsAsOptions(ZendeskType::class, ['with_fieldset' => false]);
        foreach ($fields as $field) {
            if (empty($field['value']) || empty($values[$field['value']])) {
                continue;
            }
            $return = $values[$field['value']];
        }
        return $return ?? '';
    }

    /**
     * @param FormInterface|FormInterfaceAlias $form
     * @param ResultInterface $result
     * @return array
     * @throws NoSuchEntityException
     */
    protected function mapFields(FormInterfaceAlias $form, ResultInterface $result): array
    {
        $data      = [
            'ticket' => [],
            'files'  => []
        ];
        $values    = $result->getFieldArray();
        $mapFields = $form->getZendeskMapFields() ?: [];
        foreach ($mapFields as $mapField) {
            if (empty($values[$mapField[FieldInterface::ID]])) {
                continue;
            }
            $field = $this->fieldRepository->getById((int)$mapField[FieldInterface::ID]);

            if ($field instanceof File) {
                $field->setData('result', $result);

                /** @var FileDropzoneInterface[] $files */
                $files = $field->getFilteredFieldValue();
                $value = [];
                foreach ($files as $file) {
                    $value[] = [
                        'file' => $file->getFullPath(),
                        'type' => $file->getMimeType(),
                        'name' => $file->getName()
                    ];
                }
                if ($value) {
                    $data['files'][] = [
                        'field' => $mapField[ZendeskIntegrationSettings::ZENDESK_FIELD_ID],
                        'value' => $value
                    ];
                }
            } elseif ($field instanceof Gallery) {
                $value  = [];
                $images = $field->parseValue($value);
                foreach ($images as $imageId) {
                    $file    = $this->fileGalleryRepository->getById((int)$imageId);
                    $value[] = [
                        'file' => $file->getFullPath(),
                        'type' => $file->getMimeType(),
                        'name' => $file->getName()
                    ];
                }
                if ($value) {
                    $data['files'][] = [
                        'field' => $mapField[ZendeskIntegrationSettings::ZENDESK_FIELD_ID],
                        'value' => $value
                    ];
                }
            } else {
                if ($field instanceof AbstractOption) {
                    $value = $values[$mapField[FieldInterface::ID]];
                } else {
                    $value = $field->getValueForResultTemplate(
                        $values[$mapField[FieldInterface::ID]],
                        $result->getId(),
                        ['date_format' => 'Y-m-d']
                    );
                }
                if (!isset($data['ticket']['custom_fields'])) {
                    $data['ticket']['custom_fields'] = [];
                }
                $data['ticket']['custom_fields'][] = [
                    'id'    => $mapField[ZendeskIntegrationSettings::ZENDESK_FIELD_ID],
                    'value' => $value,
                ];
            }
        }
        return $data;
    }

    /**
     * @param array $files
     * @param Api $api
     * @return array
     */
    protected function getAttachments(array $files, Api $api): array
    {
        $attachments = [];
        foreach ($files as $file) {
            try {
                $attachments[] = $api->uploadAttachment($file);
            } catch (Exception $e) {
            }
        }
        return $attachments;
    }
}