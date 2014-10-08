<?php

namespace CommonLedger\Sdk\Exception;

use Guzzle\Http\Message\Response as GuzzleResponse;

/**
 * ClientException is used when the api returns an error
 */
class ClientException extends \ErrorException
{

    public $response = null;
    public $code = null;

    public function __construct($message, $code, GuzzleResponse $response = null) {
        $this->code = $code;
        $this->response = $response;
        $this->message = $message;

        if (method_exists('parent', '__construct'))
        {
            parent::__construct($message, $code);
        }
    }

}
