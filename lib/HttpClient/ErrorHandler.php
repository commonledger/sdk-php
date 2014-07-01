<?php

namespace CommonLedger\Sdk\HttpClient;

use CommonLedger\Sdk\Exception\OAuthException;
use Guzzle\Common\Event;
use Guzzle\Http\Message\Request;

use CommonLedger\Sdk\Exception\ClientException;

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
                // OAuth errors have an error_description, so throw an OAuthException

                $oauth_params = array();
                if($request->hasHeader('Authorization')){
                    $auth_header = $request->getHeaders()->get('Authorization')->toArray();
                    list(,$access_token) = explode(' ', $auth_header[0]);
                    $oauth_params['access_token'] = $access_token;
                }

                throw new OAuthException($body['error_description'], $code, $oauth_params);
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
