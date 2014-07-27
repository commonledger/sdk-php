<?php

namespace CommonLedger\Sdk\Api;


class Analytic extends AbstractEndpoint
{

    private $endpoint = 'analytic';


    /**
     * POST /analytic
     *
     * Create a new Analytic
     *
     * @param array $body A key => value array of Analytic properties
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function add(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint, $body, $options);

        return $response;
    }

}
