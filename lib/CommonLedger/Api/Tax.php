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
     * @param $organisation_id The UUID of the organisation this tax rate belongs to
     * @param $name The name of this tax rate
     * @param $type The tax type (tax code)
     * @param $display_rate The rate to display this tax at
     * @param $effective_rate The rate that gets applied for this tax
     */
    public function add(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('/core.tax/add', $body, $options);

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

        $response = $this->client->get('/core.tax/view/'.rawurlencode($this->tax_id).'', $body, $options);

        return $response;
    }

    /**
     * Update an existing tax rate
     * '/core.tax/update/:tax_id' POST
     *
     * @param $organisation_id The UUID of the organisation this tax rate belongs to
     * @param $name The name of this tax rate
     * @param $type The tax type (tax code)
     * @param $display_rate The rate to display this tax at
     * @param $effective_rate The rate that gets applied for this tax
     */
    public function update(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('/core.tax/update/'.rawurlencode($this->tax_id).'', $body, $options);

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

        $response = $this->client->post('/core.tax/sync', $body, $options);

        return $response;
    }

}
