<?php

namespace CommonLedger\Api;

use CommonLedger\HttpClient\HttpClient;

class Organisations
{

    private $client;

    public function __construct($organisation_id, HttpClient $client)
    {
        $this->organisation_id = $organisation_id;
        $this->client = $client;
    }

    public function setOrganisationId($organisation_id){
        $this->organisation_id = $organisation_id;
    }

    public function add(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('core.organisation/add', $body, $options);

        return $response;
    }

    public function view(array $options = array())
    {
        $body = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get('core.organisation/view/'.rawurlencode($this->organisation_id).'', $body, $options);

        return $response;
    }


    public function update(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('core.organisation/update/'.rawurlencode($this->organisation_id).'', $body, $options);

        return $response;
    }


}
