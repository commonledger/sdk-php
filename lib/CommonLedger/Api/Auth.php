<?php

namespace CommonLedger\Api;

use CommonLedger\Exception\ClientException;
use CommonLedger\Exception\OAuthException;
use CommonLedger\HttpClient\HttpClient;

/**
 * Using OAuth 2.0 to connect to Common Ledger
 *
 */
class Auth {

    private $oauth_params = array();

    private $client;

    public function __construct(array $oauth_params, HttpClient $client) {
        $this->client = $client;
        $this->oauth_params = $oauth_params;
    }

    /**
     * Build the URL to redirect the user to to begin the OAuth 2.0 flow.
     *
     * @param string  $state         An optional state parameter that will be returned
     *                               when the authorization is complete
     * @param array   $organization  An associative array of organization properties
     *                               that can be used to set-up a new organization for the user
     *
     * @return string
     */
    public function getAccessCodeUrl($state = null, $organization = array()){
        $params = array(
            'client_id' => $this->oauth_params['client_id'],
            'response_type' => 'code',
            'scope' => $this->oauth_params['scope'],
            'state' => $state
        );

        if(!empty($organization))
            $params['org'] = base64_encode(json_encode($organization));

        return sprintf('%s/authorize?%s', $this->oauth_params['base'], http_build_query($params));
    }

    /**
     * Get an access token from an OAuth 2.0 access code (obtained after the authorize redirect)
     *
     * @param string $access_code  Access token from the authorize response
     * @param array  $options      Options for the request
     * @return array
     */
    public function accessToken($access_code, array $options = array()){

        $params = array(
            'client_id'      => $this->oauth_params['client_id'],
            'client_secret'	 =>	$this->oauth_params['client_secret'],
            'scope'			 =>	$this->oauth_params['scope'],
            'code'			 =>	$access_code,
            'redirect_uri'	 =>	$this->oauth_params['redirect_uri'],
            'grant_type'	 =>	'authorization_code',
        );

        return $this->oAuthRequest($params, $options);
    }

    /**
     * Obtain a new access_token using a refresh token
     *
     * @param string $refresh_token  The refresh token from a previous access_token response
     * @param array  $options        Options for the request
     * @return array
     */
    public function refreshAccessToken($refresh_token, array $options = array()) {

        $params = array(
            'client_id'		 => $this->oauth_params['client_id'],
            'client_secret'	 => $this->oauth_params['client_secret'],
            'refresh_token'	 => $refresh_token,
            'grant_type'	 => 'refresh_token',
        );

        return $this->oAuthRequest($params, $options);
    }

    private function oAuthRequest(array $params, array $options = array()){

        $url = $this->oauth_params['base'] . '/v1/authorize';
        try {
            $response = $this->client->post($url, $params, $options);
        }
        catch(ClientException $error){
            throw new OAuthException($error->getMessage());
        }

        $access_token = $response->body;
        $access_token['expires'] = date('c', time() + $access_token['expires_in']);

        return $access_token;
    }


}
