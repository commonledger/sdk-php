<?php

namespace CommonLedger\Api;

use CommonLedger\HttpClient\HttpClient;

/**
 * Using OAuth 2.0 to connect to Common Ledger
 *
 */
class Auth
{

    private $client_id;
    private $client_secret;
    private $client;

    public function __construct($client_id, $client_secret, HttpClient $client)
    {
        $this->client = $client;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    public function getAuthorizeUrl($state = ''){
        $config = $this->client->client->getConfig();
        $base_url = $config['base'] . '/' . $config['api_version'];
        $params = array(
            'scope' => 'connector',
            'response_type' => 'code',
            'client_id' => $this->client_id,
            'state' => $state
        );
        return $base_url . '/auth/authorize?' . http_build_query($params);
    }

    /**
     * After redirecting to /auth/authorise this endpoint will return an access token
     * '/auth/token' POST
     *
     * @param $client_id The application client_id
     * @param $client_secret The application client_secret
     * @param $code The code from the authorise request
     * @param $redirect_url The redirect_uri used to set up the application
     * @param $grant_type Either 'authorization_code' when requesting an access token, or 'refresh_token' when refreshing an old access token
     */
    public function token(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        if(!isset($body['client_id']))
            $body['client_id'] = $this->client_id;

        if(!isset($body['client_secret']))
            $body['client_secret'] = $this->client_secret;

        $response = $this->client->post('/auth/token', $body, $options);

        return $response;
    }

}
