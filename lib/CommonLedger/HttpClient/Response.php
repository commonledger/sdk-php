<?php

namespace CommonLedger\HttpClient;

/*
 * Response object contains the response returned by the client
 */
class Response
{
    function __construct($body, $pagination, $code, $headers) {
        $this->body = $body;
        $this->pagination = $pagination;
        $this->code = $code;
        $this->headers = $headers;
    }
}
