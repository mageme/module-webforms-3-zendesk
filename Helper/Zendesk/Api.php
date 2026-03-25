<?php

namespace MageMe\WebFormsZendesk\Helper\Zendesk;

use Exception;
use stdClass;
use Zendesk\API\Exceptions\ApiResponseException;
use Zendesk\API\Exceptions\AuthException;
use Zendesk\API\Exceptions\CustomException;
use Zendesk\API\Exceptions\MissingParametersException;
use Zendesk\API\Exceptions\ResponseException;
use Zendesk\API\HttpClient as ZendeskAPI;

class Api
{
    private $scope;

    private $authSubdomain;
    private $authEmail;
    private $authToken;
    /**
     * @var ZendeskAPI
     */
    private $api;

    #region Getters\Setters

    /**
     * @return mixed
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param mixed $scope
     * @return $this
     */
    public function setScope($scope): Api
    {
        $this->scope = $scope;
        return $this;
    }


    /**
     * @return string
     */
    public function getAuthSubdomain(): string
    {
        return (string)$this->authSubdomain;
    }

    /**
     * @param string $authSubdomain
     * @return $this
     */
    public function setAuthSubdomain(string $authSubdomain): Api
    {
        $this->authSubdomain = $authSubdomain;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthEmail(): string
    {
        return (string)$this->authEmail;
    }

    /**
     * @param string $authEmail
     * @return $this
     */
    public function setAuthEmail(string $authEmail): Api
    {
        $this->authEmail = $authEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthToken(): string
    {
        return (string)$this->authToken;
    }

    /**
     * @param string $authToken
     * @return $this
     */
    public function setAuthToken(string $authToken): Api
    {
        $this->authToken = $authToken;
        return $this;
    }
    #endregion

    /**
     * @return ZendeskAPI
     * @throws AuthException
     */
    public function getApi(): ZendeskAPI
    {
        if (!$this->api) {
            $this->initApi();
        }
        return $this->api;
    }

    /**
     * @return $this
     * @throws AuthException
     */
    public function initApi(): Api
    {
        $this->api = new ZendeskAPI($this->getAuthSubdomain());
        $this->api->setAuth('basic', [
            'username' => $this->getAuthEmail(),
            'token' => $this->getAuthToken()
        ]);
        return $this;
    }

    /**
     * @return void
     * @throws AuthException
     */
    public function checkCredentials()
    {
        try {
            $me = $this->getApi()->users()->me();
            if (empty($me->user) || empty($me->user->id)) {
                throw new AuthException(__('Invalid Zendesk API credentials.'));
            }
        } catch (Exception $exception) {
            throw new AuthException(
                __('Invalid Zendesk API credentials.: "%1"', $exception->getMessage())
            );
        }
    }

    /**
     * @return array
     * @throws AuthException
     * @throws ApiResponseException
     */
    public function getForms(): array
    {
        return $this->getApi()->get('api/v2/ticket_forms')->ticket_forms ?? [];
    }

    /**
     * @return array
     * @throws AuthException
     * @throws ApiResponseException
     */
    public function getGroups(): array
    {
        return $this->getApi()->get('api/v2/groups')->groups ?? [];
    }

    /**
     * @return array
     * @throws AuthException
     * @throws ApiResponseException
     */
    public function getAgents(): array
    {
        return $this->getApi()->get('/api/v2/users.json?role[]=admin&role[]=agent')->users ?? [];
    }

    /**
     * @return array
     * @throws ApiResponseException
     * @throws AuthException
     */
    public function getRemovableFields(): array
    {
        $fields = [];
        $api    = $this->getApi();
        $forms  = $this->getForms();

        foreach ($forms as $form) {
            foreach ($form->ticket_field_ids as $field_id) {
                $field = $api->get("api/v2/ticket_fields/$field_id")->ticket_field;
                if ($field->removable) {
                    $fields[$field->id] = $field;
                }
            }
        }
        return $fields;
    }

    /**
     * @param array $file
     * @return mixed
     * @throws AuthException
     * @throws CustomException
     * @throws MissingParametersException
     */
    public function uploadAttachment(array $file)
    {
        return $this->getApi()->attachments()->upload($file)->upload->token;
    }

    /**
     * @param array $ticket
     * @return stdClass|null
     * @throws ApiResponseException
     * @throws AuthException
     * @throws ResponseException
     */
    public function createTicket(array $ticket): ?stdClass
    {
        return $this->getApi()->tickets()->create($ticket);
    }
}