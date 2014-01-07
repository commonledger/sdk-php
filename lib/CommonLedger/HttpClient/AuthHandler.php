<?php

namespace CommonLedger\HttpClient;

use Guzzle\Common\Event;

/**
 * AuthHandler takes care of devising the auth type and using it
 */
class AuthHandler
{
    private $auth;

    const HTTP_PASSWORD = 0;

    const URL_SECRET = 2;
    const URL_TOKEN = 3;

    public function __construct(array $auth = array())
    {
        $this->auth = $auth;
    }

    /**
     * Calculating the Authentication Type
     */
    public function getAuthType()
    {

        if (isset($this->auth['username']) && isset($this->auth['password'])) {
            return self::HTTP_PASSWORD;
        }

        if (isset($this->auth['client_id']) && isset($this->auth['client_secret'])) {
            return self::URL_SECRET;
        }

        if (isset($this->auth['access_token'])) {
            return self::URL_TOKEN;
        }

        return -1;
    }

    public function onRequestBeforeSend(Event $event)
    {
        if (empty($this->auth)) {
            return;
        }

        $auth = $this->getAuthType();
        $flag = false;

        if ($auth == self::HTTP_PASSWORD) {
            $this->httpPassword($event);
            $flag = true;
        }

        if ($auth == self::URL_SECRET) {
            $this->urlSecret($event);
            $flag = true;
        }

        if ($auth == self::URL_TOKEN) {
            $this->urlToken($event);
            $flag = true;
        }

        if (!$flag) {
            throw new \ErrorException('Unable to calculate authorization method. Please check.');
        }
    }

    /**
     * Basic Authorization with username and password
     */
    public function httpPassword(Event $event)
    {
        $event['request']->setHeader('Authorization', sprintf('Basic %s', base64_encode($this->auth['username'] . ':' . $this->auth['password'])));
    }

    /**
     * OAUTH2 Authorization with client secret
     */
    public function urlSecret(Event $event)
    {
        $query = $event['request']->getQuery();

        $query->set('client_id', $this->auth['client_id']);
        $query->set('client_secret', $this->auth['client_secret']);
    }

    /**
     * OAUTH2 Authorization with access token
     */
    public function urlToken(Event $event)
    {
        $query = $event['request']->getQuery();

        $query->set('access_token', $this->auth['access_token']);
    }

}
