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

    public function setOrganizationId($organization_id){
        $this->organization_id = $organization_id;
    }

    public function add(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('core.organization/add', $body, $options);

        return $response;
    }

    public function view(array $options = array())
    {
        $body = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get('core.organization/view/'.rawurlencode($this->organization_id).'', $body, $options);

        return $response;
    }


    public function update(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('core.organization/update/'.rawurlencode($this->organization_id).'', $body, $options);

        return $response;
    }


}
