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

    public function getAccessCodeUrl($state = null){
        $params = array(
            'client_id' => $this->oauth_params['client_id'],
            'response_type' => 'code',
            'scope' => $this->oauth_params['scope'],
            'state' => $state
        );
        return sprintf('%s/authorize?%s', $this->oauth_params['base'], http_build_query($params));
    }

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
