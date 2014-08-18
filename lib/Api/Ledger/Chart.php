<?php


namespace CommonLedger\Sdk\Api\Ledger;


use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;

class Chart extends AbstractEndpoint
{

    private $ledger_id;
    private $endpoint = 'chart';
    private $chart_id;

    /**
     * Create a new Chart endpoint relative to a Ledger
     *
     * @param string $prefix
     * @param string $ledger_id
     * @param string $chart_id The UUID of the Chart
     * @param HttpClient $client
     */
    public function __construct($prefix, $ledger_id, $chart_id, HttpClient $client)
    {
        parent::__construct($client);

        $this->ledger_id = $ledger_id;
        $this->endpoint = sprintf('%s/%s/%s', $prefix, $ledger_id, $this->endpoint);
        $this->chart_id = $chart_id;
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
     * POST /ledger/{ledger_id}/chart/{chart_id}
     *
     * Update the data for a Chart on the current Ledger
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
     * DELETE /ledger/{ledger_id}/chart/{chart_id}
     *
     * Delete the association of a Chart to the current Ledger
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
        $response = $this->client->get($this->endpoint . '/count', $options);

        return $response;
    }      

    /**
     * Get the account endpoint of a Chart
     *
     * @param string $account_id The Account UUID for the account endpoint, this optional id is needed if you
     * want to call the 'Account' class member functions 'view', 'update' and 'delete'
     * @return Chart\Account
     */
    public function account($account_id = null)
    {
        return new Chart\Account($this->endpoint, $this->chart_id, $account_id, $this->client);
    }

    /**
     * Get the tax endpoint of a Chart
     *
     * @param string $tax_id The Tax UUID for the tax endpoint, this optional id is needed if you
     * want to call the 'Tax' class member functions 'view', 'update' and 'delete'.
     * @return Chart\Tax
     */
    public function tax($tax_id = null)
    {
        return new Chart\Tax($this->endpoint, $this->chart_id, $tax_id, $this->client);
    }

    /**
     * Get the journal endpoint of a Chart
     *
     * @param string $journal_id The Journal UUID for the journal endpoint, this optional id is needed if you
     * want to call the 'Journal' class member functions 'view', 'update' and 'delete'.
     * @return Chart\Journal
     */
    public function journal($journal_id = null)
    {
        return new Chart\Journal($this->endpoint, $this->chart_id, $journal_id, $this->client);
    }

}