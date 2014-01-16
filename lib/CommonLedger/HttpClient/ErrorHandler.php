<?php

namespace CommonLedger\HttpClient;

use Guzzle\Common\Event;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;

use CommonLedger\HttpClient\ResponseHandler;
use CommonLedger\Exception\ClientException;

/**
 * ErrorHanlder takes care of selecting the error message from response body
 */
class ErrorHandler
{
    public function onRequestError(Event $event)
    {
        /** @var Request $request */
        $request = $event['request'];
        $response = $request->getResponse();

        $message = null;
        $code = $response->getStatusCode();
        $status = $response->getReasonPhrase();

        $body = ResponseHandler::getBody($response);

        // If HTML, whole body is taken
        if (gettype($body) == 'string') {
            $message = $body;
        }

        // If JSON, a particular field is taken and used
        if ($response->isContentType('json') && is_array($body)) {
            if (isset($body['status'])) {
                $message = $body['status'];
            } elseif(isset($body['error_description'])) {
                $message = $body['error_description'];
            } elseif($response->isSuccessful()) {
                $message = 'Error determining status from response payload';
            }
        }

        if (empty($message)) {
            $message = "HTTP {$code}: {$status}";
        }
        throw new ClientException($message, $code, $response);

    }
}
