<?php

namespace CommonLedger\Sdk\HttpClient;

use Guzzle\Common\Event;
use Guzzle\Http\Message\Request;

/**
 * AuthHandler takes care of devising the auth type and using it
 */
class AuthHandler
{
    private $access_token;

    public function __construct($access_token) {
        $this->access_token = $access_token;
    }

    public function onRequestBeforeSend(Event $event) {

        /** @var Request $request */
        $request = $event['request'];

        if($this->access_token !== null){
            $request->addHeader('Authorization', "Bearer {$this->access_token}");
        }

    }

    /**
     * @param mixed $access_token
     */
    public function setAccessToken($access_token) {
        $this->access_token = $access_token;
    }


}
