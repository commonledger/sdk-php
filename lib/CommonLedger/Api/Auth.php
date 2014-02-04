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

    private $oauth_params = array(
        'base' => 'https://login.commonledger.com'
    );

    private $client;

    public function __construct(array $oauth_params, HttpClient $client) {
        $this->client = $client;

        $required_args = array('client_id', 'client_secret', 'redirect_uri', 'scope');
        foreach($required_args as $key){
            if(!array_key_exists($key, $oauth_params))
                throw new \InvalidArgumentException("A {$key} is required in OAuth parameters");
        }

        $this->oauth_params = array_merge($this->oauth_params, $oauth_params);
    }

    /**
     * Build the URL to redirect the user to to begin the OAuth 2.0 flow.
     *
     * @param string $state An optional state parameter that will be returned
     * when the authorization is complete
     * @param array $organization An associative array of organization properties
     * that can be used to set-up a new organization for the user
     * @param mixed $context A value passed by Common Ledger when starting to authorize
     * (used when authorization is initiated by Common Ledger)
     *
     * @return string
     */
    public function getAccessCodeUrl($state = null, $organization = array(), $context = null){
        $params = array(
            'client_id' => $this->oauth_params['client_id'],
            'redirect_uri'	 =>	$this->oauth_params['redirect_uri'],
            'response_type' => 'code',
            'scope' => $this->oauth_params['scope'],
            'state' => $state
        );

        if($context !== null)
            $params['context'] = $context;

        if(!empty($organization))
            $params['org'] = base64_encode(json_encode($organization));

        return sprintf('%s/auth?%s', $this->oauth_params['base'], http_build_query($params));
    }

    /**
     * Build a URL that will log the user out of their Common Ledger session.
     *
     * @param string $redirect_uri The URL to redirect to when the user has logged out.
     *               Must be on the same domain as the redirect_domain configured in the app settings
     * @return string
     */
    public function getLogoutUrl($redirect_uri = null){

        $params = array(
            'client_id' => $this->oauth_params['client_id'],
            'redirect_uri' => $redirect_uri
        );

        return sprintf('%s/logout?%s', $this->oauth_params['base'], http_build_query($params));
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

        if(isset($options['params']) && is_array($options['params'])){
            $params = array_merge($params, $options['params']);
            unset($options['params']);
        }

        $url = $this->oauth_params['base'] . '/token';
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
