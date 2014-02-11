<?php

namespace CommonLedger\Api;

use CommonLedger\HttpClient\HttpClient;

/**
 * Collection of different tax rates and their codes
 *
 * @param $tax_id The tax UUID
 */
class Tax
{

    private $tax_id;
    private $client;

    public function __construct($tax_id, HttpClient $client)
    {
        $this->tax_id = $tax_id;
        $this->client = $client;
    }

    /**
     * Add a new tax rate
     * '/core.tax/add' POST
     *
     */
    public function add(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('tax', $body, $options);

        return $response;
    }

    /**
     * Synchronises a set of tax rates
     * '/core.tax/sync' POST
     *
     */
    public function sync(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('tax/sync', $body, $options);

        return $response;
    }

    /**
     * View a tax rate
     * '/core.tax/view/:tax_id' GET
     *
     */
    public function view(array $options = array())
    {
        $body = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get('tax/'.rawurlencode($this->tax_id).'', $body, $options);

        return $response;
    }

    /**
     * Update an existing tax rate
     * '/core.tax/update/:tax_id' POST
     *
     */
    public function update(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('tax/'.rawurlencode($this->tax_id).'', $body, $options);

        return $response;
    }

    /**
     * Get the number of accounts for an organization. Defaults to current organization_id,
     * unless specified in the query
     */
    public function count(array $options = array())
    {
        $body = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get('tax/count', $body, $options);

        return $response;
    }

}
