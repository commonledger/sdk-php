<?php

namespace CommonLedger\Sdk\Exception;

use Guzzle\Http\Message\Response as GuzzleResponse;

/**
 * ClientException is used when the api returns an error
 */
class ClientException extends \ErrorException implements ExceptionInterface
{

    public $response = null;
    public $code = null;

    public function __construct($message, $code, GuzzleResponse $response = null) {
        $this->code = $code;
        $this->response = $response;
        parent::__construct($message);
    }

}
