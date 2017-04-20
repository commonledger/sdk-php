<?php


namespace CommonLedger\Sdk\Api\Ledger\Chart;


use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;
use Commonledger\Sdk\Exception;

class Journal extends AbstractEndpoint
{

    private $chart_id;
    private $endpoint = 'journal';
    private $journal_id;

    /**
     * Create a new Journal endpoint relative to a Chart on a Ledger
     *
     * @param string $prefix
     * @param string $chart_id
     * @param string $journal_id The UUID of the Journal to fetch
     * @param HttpClient $client
     */
    public function __construct($prefix, $chart_id, $journal_id, HttpClient $client)
    {
        parent::__construct($client);

        $this->chart_id = $chart_id;
        $this->endpoint = sprintf('%s/%s/%s', $prefix, $chart_id, $this->endpoint);
        $this->journal_id = $journal_id;

    }


    /**
     * GET /ledger/{ledger_id}/chart/{chart_id}/journal
     *
     * List the Journals for the current Chart
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
     * POST /ledger/{ledger_id}/chart/{chart_id}/journal
     *
     * Create a new Journal on the current Chart
     *
     * @param array $body A key => value array of Journal properties
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
     * GET /ledger/{ledger_id}/chart/{chart_id}/journal/{journal_id}
     *
     * Get a Journal from the current Chart by the Journal id
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . $this->journal_id, $query, $options);

        return $response;
    }

    /**
     * POST /ledger/{ledger_id}/chart/{chart_id}/journal/{journal_id}
     *
     * Update the data for a Journal on the current Chart
     *
     * @param array $body The Journal data
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function update(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint . '/' . $this->journal_id, $body, $options);

        return $response;
    }

    /**
     * DELETE /ledger/{ledger_id}/chart/{chart_id}/journal/{journal_id}
     *
     * Delete a Journal from the current Chart
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function delete(array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());

        $response = $this->client->delete($this->endpoint . '/' . $this->journal_id, $body, $options);

        return $response;
    }

    /**
     * POST /ledger/{ledger_id}/chart/{chart_id}/journal/sync
     *
     * Sync multiple Journal objects with the current Chart. Uses origin id properties for
     * collision detection. Primarily used by foreign accounting package Connectors.
     *
     * @param array $body An array of Journal objects
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function sync(array $body, array $options = array())
    {
        if (isset($options['body'])) {
            $body = array_merge($body, $options['body']);
        }
        try {
            $response = $this->client->post($this->endpoint . '/sync', $body, $options);
        } catch (\Exception $e) {
            echo $e->getMessage();
            $data = $e->getData();
            if (!empty($data)) {
                print_r($data);
            }
            return false;
        }
        return $response;
    }

    /**
     * GET /ledger/{ledger_id}/chart/{chart_id}/journal/count
     *
     * Get a count of the current number of Journals for the current Chart
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function count(array $options = array())
    {
        $response = $this->client->get($this->endpoint . '/count', $options);

        return $response->body['count'];
    }      

    /**
     * POST /ledger/{ledger_id}/chart/{chart_id}/journal/reverse
     *
     * Reverse multiple Journal objects.
     *
     * @param array $ids An array of Journal ids
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function reverse(array $ids, array $options = array())
    {
        try {
            $response = $this->client->post($this->endpoint . '/reverse', $ids, $options);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        return $response;
    }

    /**
     * POST /ledger/{ledger_id}/chart/{chart_id}/journal/clearOriginIds
     *
     * Clear origin_ids out from the database.
     *
     * @param array $ids
     * @param array $options
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function clearOriginIds(array $ids, array $options = [])
    {
        try {
            $response = $this->client->post($this->endpoint. '/clearOriginIds', $ids, $options);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        return $response;
    }
}