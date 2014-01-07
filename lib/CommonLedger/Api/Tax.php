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
    public function add($organisation_id, $name, $type, $display_rate, $effective_rate, array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());
        $body['organisation_id'] = $organisation_id;
        $body['name'] = $name;
        $body['type'] = $type;
        $body['display_rate'] = $display_rate;
        $body['effective_rate'] = $effective_rate;

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
    public function update($organisation_id, $name, $type, $display_rate, $effective_rate, array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());
        $body['organisation_id'] = $organisation_id;
        $body['name'] = $name;
        $body['type'] = $type;
        $body['display_rate'] = $display_rate;
        $body['effective_rate'] = $effective_rate;

        $response = $this->client->post('/core.tax/update/'.rawurlencode($this->tax_id).'', $body, $options);

        return $response;
    }

}
