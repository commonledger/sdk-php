<?php

namespace CommonLedger\Sdk\HttpClient;

use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\RequestInterface;

use CommonLedger\Sdk\HttpClient\AuthHandler;
use CommonLedger\Sdk\HttpClient\ErrorHandler;
use CommonLedger\Sdk\HttpClient\RequestHandler;
use CommonLedger\Sdk\HttpClient\Response;
use CommonLedger\Sdk\HttpClient\ResponseHandler;

/**
 * Main HttpClient which is used by Api classes
 */
class HttpClient
{
    protected $options = array(
        'base'    => 'https://api.commonledger.io',
        'api_version' => 'v1',
        'user_agent' => 'commonledger-php-sdk/1.0 (https://github.com/commonledger/sdk-php)'
    );

    protected $headers = array();

    private $auth_handler;
    private $error_handler;

    public function __construct($access_token = null, array $options = array()) {

        $this->options = array_merge($this->options, $options);

        $this->headers = array(
            'user-agent' => $this->options['user_agent'],
        );

        if (isset($this->options['headers'])) {
            $this->headers = array_merge($this->headers, array_change_key_case($this->options['headers']));
            unset($this->options['headers']);
        }

        $version = (isset($this->options['api_version']) ? "/".$this->options['api_version'] : "");
        $base_url = $this->options['base'] . $version;

        $client = new GuzzleClient($base_url, $this->options);
        $this->client  = $client;

        $this->error_handler = new ErrorHandler();
        $listener = array($this->error_handler, 'onRequestError');
        $this->client->getEventDispatcher()->addListener('request.error', $listener);

        $this->auth_handler = new AuthHandler($access_token);
        $listener = array($this->auth_handler, 'onRequestBeforeSend');
        $this->client->getEventDispatcher()->addListener('request.before_send', $listener);

    }

    public function setAccessToken($access_token){
        $this->auth_handler->setAccessToken($access_token);
    }

    public function get($path, array $params = array(), array $options = array())
    {
        try {
            $response = $this->request($path, null, 'GET', array_merge($options, array('query' => $params)));
        } catch (\CommonLedger\Sdk\Exception\ClientException $e) {
            throw $e;
        }
        return $response;
    }

    public function post($path, $body, array $options = array())
    {
        try {
            $response = $this->request($path, $body, 'POST', $options);
        } catch (\CommonLedger\Sdk\Exception\ClientException $e) {
            throw $e;
        }
        return $response;
    }

    public function patch($path, $body, array $options = array())
    {
        try {
            $response = $this->request($path, $body, 'PATCH', $options);
        } catch (\CommonLedger\Sdk\Exception\ClientException $e) {
            throw $e;
        }
        return $response;
    }

    public function delete($path, $body, array $options = array())
    {
        try {
            $response = $this->request($path, $body, 'DELETE', $options);
        } catch (\CommonLedger\Sdk\Exception\ClientException $e) {
            throw $e;
        }
        return $response;
    }

    public function put($path, $body, array $options = array())
    {
        try {
            $response = $this->request($path, $body, 'PUT', $options);
        } catch (\CommonLedger\Sdk\Exception\ClientException $e) {
            throw $e;
        }
        return $response;
    }

    /**
     * Intermediate function which does three main things
     *
     * - Transforms the body of request into correct format
     * - Creates the requests with give parameters
     * - Returns response body after parsing it into correct format
     */
    public function request($path, $body = null, $httpMethod = 'GET', array $options = array())
    {
        $headers = array();

        $options = array_merge($this->options, $options);

        if (isset($options['headers'])) {
            $headers = $options['headers'];
            unset($options['headers']);
        }

        $headers = array_merge($this->headers, array_change_key_case($headers));

        unset($options['body']);

        unset($options['base']);
        unset($options['user_agent']);

        $request = $this->createRequest($httpMethod, $path, null, $headers, $options);

        if ($httpMethod != 'GET') {
            $request = $this->setBody($request, $body, $options);
        }

        try {
            $response = $this->client->send($request);
            $body = $this->getBody($response);
        } catch (\LogicException $e) {
            throw new \ErrorException($e->getMessage());
        } catch (\RuntimeException $e) {
            throw new \RuntimeException($e->getMessage());
        } catch (\CommonLedger\Sdk\Exception\ClientException $e) {
            throw $e;
        }

        $pagination = isset($body['pagination']) ? $body['pagination']: array();

        $data = (isset($body['data'])) ? $body['data'] : array();
        return new Response($data, $pagination, $response->getStatusCode(), $response->getHeaders());
    }

    /**
     * Creating a request with the given arguments
     *
     * If api_version is set, appends it immediately after host
     */
    public function createRequest($httpMethod, $path, $body = null, array $headers = array(), array $options = array())
    {
        return $this->client->createRequest($httpMethod, $path, $headers, $body, $options);
    }

    /**
     * Get response body in correct format
     */
    public function getBody($response)
    {
        return ResponseHandler::getBody($response);
    }

    /**
     * Set request body in correct format
     */
    public function setBody(RequestInterface $request, $body, $options)
    {
        return RequestHandler::setBody($request, $body, $options);
    }
}
