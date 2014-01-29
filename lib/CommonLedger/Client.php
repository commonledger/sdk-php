<?php

namespace CommonLedger;

use CommonLedger\HttpClient\HttpClient;

class Client
{
    protected $httpClient;

    public function __construct($access_token = null, array $options = array())
    {
        $this->httpClient = new HttpClient($access_token, $options);
    }

    /**
     * Set the access token to use when making requests.
     *
     * @param string $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->httpClient->setAccessToken($access_token);
    }

    /**
     * Get and refresh OAuth 2.0 access tokens
     *
     * @param array $oauth_params The parameters required to connect to the OAuth endpoints
     * @return \CommonLedger\Api\Auth
     */
    public function auth(array $oauth_params)
    {
        return new Api\Auth($oauth_params, $this->httpClient);
    }

    /**
     * Manages data relating to the Chart of Accounts
     *
     * @param string $account_id The account UUID
     * @return \CommonLedger\Api\Accounts
     */
    public function accounts($account_id)
    {
        return new Api\Accounts($account_id, $this->httpClient);
    }

    /**
     * Collection of different tax rates and their codes
     *
     * @param string $tax_id The tax UUID
     */
    public function tax($tax_id)
    {
        return new Api\Tax($tax_id, $this->httpClient);
    }

    /**
     * Manages journal entries and journal lines
     *
     * @param string $journal_id The journal entry UUID
     */
    public function journals($journal_id)
    {
        return new Api\Journals($journal_id, $this->httpClient);
    }

    /**
     * Manages organizations
     *
     * @param string $journal_id The organization UUID
     */
    public function organizations($organization_id)
    {
        return new Api\Organizations($organization_id, $this->httpClient);
    }

    /**
     * Manage users
     *
     * @param string $user_id The user UUID
     */
    public function users($user_id)
    {
        return new Api\Users($user_id, $this->httpClient);
    }

}
