<?php

namespace MageMe\WebFormsZendesk\Config\Options;

use Exception;
use MageMe\WebFormsZendesk\Helper\ZendeskHelper;
use Magento\Framework\Data\OptionSourceInterface;

class Agents implements OptionSourceInterface
{
    /**
     * @var array
     */
    private $options;
    /**
     * @var ZendeskHelper
     */
    private $zendeskHelper;

    /**
     * @param ZendeskHelper $zendeskHelper
     */
    public function __construct(ZendeskHelper $zendeskHelper)
    {
        $this->zendeskHelper = $zendeskHelper;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        if ($this->options) {
            return $this->options;
        }
        try {
            $options = [];
            foreach ($this->zendeskHelper->getApi()->getAgents() as $user) {
                $options[] = [
                    'label' => $user->name,
                    'value' => (string)$user->id
                ];
            }
            $this->options = $options;
        } catch (Exception $exception) {
            $this->options = [];
        }
        return $this->options;
    }

}