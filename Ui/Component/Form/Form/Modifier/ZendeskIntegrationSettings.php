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

namespace MageMe\WebFormsZendesk\Ui\Component\Form\Form\Modifier;

use MageMe\WebForms\Api\Data\FieldInterface;
use MageMe\WebForms\Api\Data\FormInterface as FormInterfaceAlias;
use MageMe\WebForms\Api\FormRepositoryInterface;
use MageMe\WebForms\Model\Field\Type\Email;
use MageMe\WebFormsZendesk\Api\Data\FormInterface;
use MageMe\WebFormsZendesk\Config\Options\Agents;
use MageMe\WebFormsZendesk\Config\Options\CustomFields;
use MageMe\WebFormsZendesk\Config\Options\Groups;
use MageMe\WebFormsZendesk\Config\Options\Priority;
use MageMe\WebFormsZendesk\Config\Options\Type;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\Component\Container;
use Magento\Ui\Component\DynamicRows;
use Magento\Ui\Component\Form;
use Magento\Ui\Component\Form\Element\ActionDelete;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class ZendeskIntegrationSettings implements ModifierInterface
{
    const ZENDESK_FIELD_ID = 'zendesk_field_id';

    /**
     * @var FormRepositoryInterface
     */
    private $formRepository;
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var Priority
     */
    private $zendeskPriority;
    /**
     * @var Type
     */
    private $zendeskType;
    /**
     * @var Agents
     */
    private $zendeskAgents;
    /**
     * @var Groups
     */
    private $zendeskGroups;
    /**
     * @var CustomFields
     */
    private $zendeskCustomFields;

    /**
     * @param CustomFields $zendeskCustomFields
     * @param Groups $zendeskGroups
     * @param Agents $zendeskAgents
     * @param Type $zendeskType
     * @param Priority $zendeskPriority
     * @param RequestInterface $request
     * @param FormRepositoryInterface $formRepository
     */
    public function __construct(
        CustomFields            $zendeskCustomFields,
        Groups                  $zendeskGroups,
        Agents                  $zendeskAgents,
        Type                    $zendeskType,
        Priority                $zendeskPriority,
        RequestInterface        $request,
        FormRepositoryInterface $formRepository
    ) {
        $this->formRepository      = $formRepository;
        $this->request             = $request;
        $this->zendeskPriority     = $zendeskPriority;
        $this->zendeskType         = $zendeskType;
        $this->zendeskAgents       = $zendeskAgents;
        $this->zendeskGroups       = $zendeskGroups;
        $this->zendeskCustomFields = $zendeskCustomFields;
    }

    /**
     * @inheritdoc
     */
    public function modifyData(array $data): array
    {
        return $data;
    }

    /**
     * @inheritdoc
     */
    public function modifyMeta(array $meta): array
    {
        $meta['zendesk_integration_settings'] = $this->getZendeskFieldsetMeta();
        return $meta;
    }

    /**
     * @return array
     */
    private function getZendeskFieldsetMeta(): array
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Form\Fieldset::NAME,
                        'label' => __('Zendesk Integration Settings'),
                        'sortOrder' => 150,
                        'collapsible' => true,
                        'opened' => false,
                    ]
                ]
            ],
            'children' => [
                FormInterface::IS_ZENDESK_ENABLED => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Checkbox::NAME,
                                'dataType' => Form\Element\DataType\Boolean::NAME,
                                'visible' => 1,
                                'sortOrder' => 10,
                                'label' => __('Enable Zendesk Integration'),
                                'default' => '0',
                                'prefer' => 'toggle',
                                'valueMap' => ['false' => '0', 'true' => '1'],
                            ]
                        ]
                    ]
                ],
                FormInterface::ZENDESK_EMAIL_FIELD_ID => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Select::NAME,
                                'dataType' => Form\Element\DataType\Number::NAME,
                                'visible' => 1,
                                'sortOrder' => 20,
                                'label' => __('Customer Email'),
                                'options' => $this->getFields(Email::class),
                                'caption' => __('Default'),
                            ]
                        ]
                    ]
                ],
                FormInterface::ZENDESK_GROUP => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Select::NAME,
                                'dataType' => Form\Element\DataType\Number::NAME,
                                'visible' => 1,
                                'sortOrder' => 30,
                                'label' => __('Group'),
                                'options' => $this->zendeskGroups->toOptionArray(),
                                'caption' => __('No Group'),
                            ]
                        ]
                    ]
                ],
                FormInterface::ZENDESK_PRIORITY => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Select::NAME,
                                'dataType' => Form\Element\DataType\Number::NAME,
                                'visible' => 1,
                                'sortOrder' => 40,
                                'label' => __('Priority'),
                                'options' => $this->zendeskPriority->toOptionArray(),
                                'caption' => __('Default'),
                            ]
                        ]
                    ]
                ],
                FormInterface::ZENDESK_TYPE => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Select::NAME,
                                'dataType' => Form\Element\DataType\Number::NAME,
                                'visible' => 1,
                                'sortOrder' => 50,
                                'label' => __('Type'),
                                'options' => $this->zendeskType->toOptionArray(),
                                'caption' => __('Default'),
                            ]
                        ]
                    ]
                ],
                FormInterface::ZENDESK_FOLLOWERS => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\MultiSelect::NAME,
                                'visible' => 1,
                                'sortOrder' => 60,
                                'label' => __('Followers'),
                                'options' => $this->zendeskAgents->toOptionArray(),
                            ]
                        ]
                    ]
                ],
                FormInterface::ZENDESK_TAGS => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Textarea::NAME,
                                'dataType' => Form\Element\DataType\Text::NAME,
                                'visible' => 1,
                                'sortOrder' => 70,
                                'label' => __('Tags'),
                                'additionalInfo' => __('Tags should be separated with new line'),
                                'rows' => 5,
                            ]
                        ]
                    ]
                ],
                FormInterface::ZENDESK_MAP_FIELDS => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => DynamicRows::NAME,
                                'visible' => 1,
                                'sortOrder' => 80,
                                'label' => __('Fields Mapping'),
                            ]
                        ]
                    ],
                    'children' => [
                        'record' => [
                            'arguments' => [
                                'data' => [
                                    'config' => [
                                        'componentType' => Container::NAME,
                                        'isTemplate' => true,
                                        'is_collection' => true,
                                    ]
                                ]
                            ],
                            'children' => [
                                self::ZENDESK_FIELD_ID => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'componentType' => Form\Field::NAME,
                                                'formElement' => Form\Element\Select::NAME,
                                                'dataType' => Form\Element\DataType\Text::NAME,
                                                'visible' => 1,
                                                'sortOrder' => 10,
                                                'label' => __('Zendesk Ticket Attribute'),
                                                'options' => $this->zendeskCustomFields->toOptionArray(),
                                                'validation' => [
                                                    'required-entry' => true,
                                                ],
                                            ]
                                        ]
                                    ]
                                ],
                                FieldInterface::ID => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'componentType' => Form\Field::NAME,
                                                'formElement' => Form\Element\Select::NAME,
                                                'dataType' => Form\Element\DataType\Text::NAME,
                                                'visible' => 1,
                                                'sortOrder' => 20,
                                                'label' => __('Field'),
                                                'options' => $this->getFields(),
                                                'validation' => [
                                                    'required-entry' => true,
                                                ],
                                            ]
                                        ]
                                    ]
                                ],
                                ActionDelete::NAME => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'componentType' => ActionDelete::NAME,
                                                'dataType' => Form\Element\DataType\Text::NAME,
                                                'label' => '',
                                                'sortOrder' => 30,
                                            ],
                                        ],
                                    ],
                                ],
                            ]
                        ]
                    ]
                ],
            ]
        ];
    }

    /**
     * @param mixed $type
     * @return array
     */
    protected function getFields($type = false): array
    {
        $formId = (int)$this->request->getParam(FormInterfaceAlias::ID);
        if (!$formId) {
            return [];
        }
        try {
            return $this->formRepository->getById($formId)->getFieldsAsOptions($type);
        } catch (NoSuchEntityException $e) {
            return [];
        }
    }
}
