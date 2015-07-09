<?php


namespace CommonLedger\Sdk\Api\Ledger\Chart;

use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;

class Transaction extends AbstractEndpoint
{

    private $chart_id;
    private $endpoint = 'transaction';
    private $transaction_id;

    /**
     * Create a new Transaction endpoint relative to a Chart on a Ledger
     *
     * @param string $prefix
     * @param string $chart_id
     * @param string $transaction_id The UUID of the Transaction to fetch
     * @param HttpClient $client
     */
    public function __construct($prefix, $chart_id, $transaction_id, HttpClient $client)
    {
        parent::__construct($client);

        $this->chart_id = $chart_id;
        $this->endpoint = sprintf('%s/%s/%s', $prefix, $chart_id, $this->endpoint);
        $this->transaction_id = $transaction_id;

    }


    /**
     * GET /ledger/{ledger_id}/chart/{chart_id}/transaction
     *
     * List the Transactions for the current Chart
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
     * POST /ledger/{ledger_id}/chart/{chart_id}/transaction
     *
     * Create a new Transaction on the current Chart
     *
     * @param array $body A key => value array of Transaction properties
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
     * GET /ledger/{ledger_id}/chart/{chart_id}/transaction/{transaction_id}
     *
     * Get a Transaction from the current Chart by the Transaction id
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . $this->transaction_id, $query, $options);

        return $response;
    }

    /**
     * POST /ledger/{ledger_id}/chart/{chart_id}/transaction/{transaction_id}
     *
     * Update the data for a Transaction on the current Chart
     *
     * @param array $body The Transaction data
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function update(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint . '/' . $this->transaction_id, $body, $options);

        return $response;
    }

    /**
     * DELETE /ledger/{ledger_id}/chart/{chart_id}/transaction/{transaction_id}
     *
     * Delete a Transaction from the current Chart
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function delete(array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());

        $response = $this->client->delete($this->endpoint . '/' . $this->transaction_id, $body, $options);

        return $response;
    }

    /**
     * POST /ledger/{ledger_id}/chart/{chart_id}/transaction/sync
     *
     * Sync multiple Transaction objects with the current Chart. Uses origin id properties for
     * collision detection. Primarily used by foreign accounting package Connectors.
     *
     * @param array $body An array of Transaction objects
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function sync(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint . '/sync', $body, $options);

        return $response;
    }

    /**
     * GET /ledger/{ledger_id}/chart/{chart_id}/transaction/count
     *
     * Get a count of the current number of Transactions for the current Chart
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

}