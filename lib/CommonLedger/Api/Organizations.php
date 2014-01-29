<?php

namespace CommonLedger\Api;

use CommonLedger\HttpClient\HttpClient;

class Organizations
{

    private $client;

    public function __construct($organization_id, HttpClient $client)
    {
        $this->organization_id = $organization_id;
        $this->client = $client;
    }

    public function index(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get('organization', $query, $options);

        return $response;
    }

    public function add(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('organization', $body, $options);

        return $response;
    }

    public function view(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get('organization/'.rawurlencode($this->organization_id), $query, $options);

        return $response;
    }


    public function update(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('organization/'.rawurlencode($this->organization_id), $body, $options);

        return $response;
    }


}
