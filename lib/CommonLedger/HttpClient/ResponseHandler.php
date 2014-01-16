<?php

namespace CommonLedger\HttpClient;

use CommonLedger\Exception\ClientException;
use Guzzle\Http\Message\Response as GuzzleResponse;

/**
 * ResponseHandler takes care of decoding the response body into suitable type
 */
class ResponseHandler {

    public static function getBody(GuzzleResponse $response)
    {
        $body = $response->getBody(true);

        // Response body is in JSON
        if ($response->isContentType('json')) {
            $body = json_decode($body, true);

            if (JSON_ERROR_NONE !== json_last_error() || !is_array($body)) {
                throw new ClientException("Malformed JSON response from Common Ledger API", 500);
            }

            // might be an OAuth response, which isn't wrapped in the standard payload.
            if(isset($body['access_token']) || isset($body['error'])){
                return $body;
            }
            // otherwise, if it has a status property thats OK, its properly formed
            else if(isset($body['status']) && $body['status'] === 'OK'){
                return $body['data'];
            }
            // throw an exception if the data isn't in the format we expect (unsuccessful responses will be handled in the errorhandler
            else if(!$response->isSuccessful()) {
                $status = isset($body['status']) ? $body['status'] : 'UNKNOWN_ERROR';
                $code = $response->getStatusCode();

                $message = "Error in response: {$status}";
                if(isset($body['data']) && is_array($body['data']) && array_key_exists('message', $body['data']))
                    $message = "{$status}: {$body['data']['message']}";

                throw new ClientException($message, $code, $response);
            }
        }

        return $body;
    }

}
