<?php


namespace CommonLedger\Sdk\Api\Ledger;


use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;

class Chart extends AbstractEndpoint
{

    private $ledger_id;
    private $endpoint = 'chart';

    /**
     * Create a new Chart endpoint relative to a Ledger
     *
     * @param string $prefix
     * @param string $ledger_id
     * @param HttpClient $client
     */
    public function __construct($prefix, $ledger_id, HttpClient $client)
    {
        parent::__construct($client);

        $this->ledger_id = $ledger_id;
        $this->endpoint = sprintf('%s/%s/%s', $prefix, $ledger_id, $this->endpoint);
    }


    /**
     * GET /ledger/{ledger_id}/chart
     *
     * List the Charts for the current Ledger
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
     * POST /ledger/{ledger_id}/chart
     *
     * Create a new Chart on the current Ledger, or associate an existing Chart to
     * the current Ledger
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
     * GET /ledger/{ledger_id}/chart/{chart_id}
     *
     * Get a Chart from the current Ledger by the Chart id
     *
     * @param string $chart_id The UUID of the Chart to fetch
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view($chart_id, array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . $chart_id, $query, $options);

        return $response;
    }

    /**
     * POST /ledger/{ledger_id}/chart/{chart_id}
     *
     * Update the data for a Chart on the current Ledger
     *
     * @param string $chart_id The UUID of the Chart
     * @param array $body The Chart data
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function update($chart_id, array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint . '/' . $chart_id, $body, $options);

        return $response;
    }

    /**
     * DELETE /ledger/{ledger_id}/chart/{chart_id}
     *
     * Delete the association of a Chart to the current Ledger
     *
     * @param string $chart_id The UUID of the Chart to delete
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function delete($chart_id, array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());

        $response = $this->client->delete($this->endpoint . '/' . $chart_id, $body, $options);

        return $response;
    }

    /**
     * GET /ledger/{ledger_id}/chart/count
     *
     * Get a count of the current number of Charts for the current Ledger
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function count(array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint, $body, $options);

        return $response;
    }      

    /**
     * Get the account endpoint of a Chart
     *
     * @param string $chart_id The Chart UUID for the account endpoint
     * @return Chart\Account
     */
    public function account($chart_id)
    {
        return new Chart\Account($this->endpoint, $chart_id, $this->client);
    }

    /**
     * Get the tax endpoint of a Chart
     *
     * @param string $chart_id The Chart UUID for the tax endpoint
     * @return Chart\Account
     */
    public function tax($chart_id)
    {
        return new Chart\Tax($this->endpoint, $chart_id, $this->client);
    }

    /**
     * Get the journal endpoint of a Chart
     *
     * @param string $chart_id The Chart UUID for the journal endpoint
     * @return Chart\Account
     */
    public function journal($chart_id)
    {
        return new Chart\Journal($this->endpoint, $chart_id, $this->client);
    }

}