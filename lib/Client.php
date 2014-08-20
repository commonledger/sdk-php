<?php

namespace CommonLedger\Sdk;

use CommonLedger\Sdk\HttpClient\HttpClient;

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
     * Query the current status of the API
     *
     * @param array $options
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function status(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->httpClient->get('api/status', $query, $options);

        return $response;
    }

    /**
     * Get a new Analytic endpoint for managing analytics
     *
     * @return \CommonLedger\Sdk\Api\Analytic
     */
    public function analytic()
    {
        return new Api\Analytic($this->httpClient);
    }

    /**
     * Get and refresh OAuth 2.0 access tokens
     *
     * @param array $oauth_params The parameters required to connect to the OAuth endpoints
     * @return \CommonLedger\Sdk\Api\Auth
     */
    public function auth(array $oauth_params)
    {
        return new Api\Auth($oauth_params, $this->httpClient);
    }

    /**
     * Get a new Ledger instance for managing ledgers
     *
     * @param string $ledger_id, this optional id is needed if calling the 'Ledger' class member
     * functions 'view', 'update', 'delete', 'addon', 'chart', 'document' and 'report'.
     * @return \CommonLedger\Sdk\Api\Ledger
     */
    public function ledger($ledger_id = 'current')
    {
        return new Api\Ledger($ledger_id, $this->httpClient);
    }

    /**
     * Get a new User instance for managing users
     *
     * @param string $user_id, this optional id is needed if calling the 'User' class member functions
     * 'view', 'update', 'delete', 'addon', 'chart', 'document' and 'ledger'.
     * @return \CommonLedger\Sdk\Api\User
     */
    public function user($user_id = 'current')
    {
        return new Api\User($user_id, $this->httpClient);
    }
    
    /**
     * Return the raw HttpClient used for this connection.
     *
     * @return \CommonLedger\Sdk\HttpClient\HttpClient
     */
    public function api()
    {
    	return $this->httpClient;
    }
    
    

}
