<?php


namespace CommonLedger\Sdk\Api\User\Chart;

use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;

class Tax extends AbstractEndpoint
{

    private $chart_id;
    private $endpoint = 'tax';

    /**
     * Create a new Tax endpoint relative to a Chart for a User
     *
     * @param string $prefix
     * @param string $chart_id
     * @param HttpClient $client
     */
    public function __construct($prefix, $chart_id, HttpClient $client)
    {
        parent::__construct($client);

        $this->chart_id = $chart_id;
        $this->endpoint = sprintf('%s/%s/%s', $prefix, $chart_id, $this->endpoint);

    }


    /**
     * GET /user/{user_id}/chart/{chart_id}/tax
     *
     * List the Taxes for the current Chart
     *
     * @param array $options
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function index(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint, $query, $options);

        return $response;
    }

    /**
     * POST /user/{user_id}/chart/{chart_id}/tax
     *
     * Create a new Tax on the current Chart
     *
     * @param array $body A key => value array of Tax properties
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

    /**
     * GET /user/{user_id}/chart/{chart_id}/tax/{tax_id}
     *
     * Get a Tax from the current Chart by the Tax id
     *
     * @param string $tax_id The UUID of the Tax to fetch
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view($tax_id, array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . $tax_id, $query, $options);

        return $response;
    }

    /**
     * POST /user/{user_id}/chart/{chart_id}/tax/{tax_id}
     *
     * Update the data for a Tax on the current Chart
     *
     * @param string $tax_id The UUID of the Tax
     * @param array $body The Tax data
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function update($tax_id, array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint . '/' . $tax_id, $body, $options);

        return $response;
    }

    /**
     * DELETE /user/{user_id}/chart/{chart_id}/tax/{tax_id}
     *
     * Delete a Tax from the current Chart
     *
     * @param string $tax_id The UUID of the Tax to delete
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function delete($tax_id, array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());

        $response = $this->client->delete($this->endpoint . '/' . $tax_id, $body, $options);

        return $response;
    }

}