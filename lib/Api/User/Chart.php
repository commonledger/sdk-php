<?php


namespace CommonLedger\Sdk\Api\User;


use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;

class Chart extends AbstractEndpoint
{

    private $user_id;
    private $endpoint = 'chart';
    private $chart_id;

    /**
     * Create a new Chart endpoint relative to a User
     *
     * @param string $prefix
     * @param string $user_id
     * @param string $chart_id
     * @param HttpClient $client
     */
    public function __construct($prefix, $user_id, $chart_id, HttpClient $client)
    {
        parent::__construct($client);

        $this->user_id = $user_id;
        $this->endpoint = sprintf('%s/%s/%s', $prefix, $user_id, $this->endpoint);
        $this->chart_id = $chart_id;
    }


    /**
     * GET /user/{user_id}/chart
     *
     * List the Charts for the current User
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function index(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint, $query, $options);

        return $response;
    }

    /**
     * POST /user/{user_id}/chart
     *
     * Create a new Chart for the current User, or associate an existing Chart to
     * the current User
     *
     * @param array $body A key => value array of Chart properties
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
     * GET /user/{user_id}/chart/{chart_id}
     *
     * Get a Chart from the current User by the Chart id
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . $this->chart_id, $query, $options);

        return $response;
    }

    /**
     * POST /user/{user_id}/chart/{chart_id}
     *
     * Update the data for a Chart on the current User
     *
     * @param array $body The Chart data
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function update(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint . '/' . $this->chart_id, $body, $options);

        return $response;
    }

    /**
     * DELETE /user/{user_id}/chart/{chart_id}
     *
     * Delete the association of a Chart to the current User
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function delete(array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());

        $response = $this->client->delete($this->endpoint . '/' . $this->chart_id, $body, $options);

        return $response;
    }

    /**
     * GET /user/{user_id}/chart/count
     *
     * Get a count of the current number of Charts for the current User
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function count(array $options = array())
    {
        $response = $this->client->get($this->endpoint . '/count', $options);

        return $response;
    }   

    /**
     * Get the account endpoint of a Chart
     *
     * @param string $account_id The Account UUID for the account endpoint
     * @return Chart\Account
     */
    public function account($account_id)
    {
        return new Chart\Account($this->endpoint, $this->$chart_id, $account_id, $this->client);
    }

    /**
     * Get the tax endpoint of a Chart
     *
     * @param string $tax_id The Tax UUID for the tax endpoint
     * @return Chart\Tax
     */
    public function tax($tax_id)
    {
        return new Chart\Tax($this->endpoint, $this->chart_id, $tax_id, $this->client);
    }

    /**
     * Get the map endpoint of a Chart
     *
     * @param string $map_id The Map UUID for the map endpoint
     * @return Chart\Map
     */
    public function map($map_id)
    {
        return new Chart\Map($this->endpoint, $this->chart_id, $map_id, $this->client);
    }

}