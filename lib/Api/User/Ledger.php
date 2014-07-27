<?php


namespace CommonLedger\Sdk\Api\User;


use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;

class Ledger extends AbstractEndpoint
{

    private $user_id;
    private $endpoint = 'ledger';

    /**
     * Create a new Ledger endpoint relative to a User
     *
     * @param string $prefix
     * @param string $user_id
     * @param HttpClient $client
     */
    public function __construct($prefix, $user_id, HttpClient $client)
    {
        parent::__construct($client);

        $this->user_id = $user_id;
        $this->endpoint = sprintf('%s/%s/%s', $prefix, $user_id, $this->endpoint);
    }


    /**
     * GET /user/{user_id}/ledger
     *
     * List the Ledgers for the current User. These are external tools that connect on behalf
     * of a User and push/pull data.
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
     * GET /user/{user_id}/ledger/{ledger_id}
     *
     * Get an Ledger from the current User by the Ledger id
     *
     * @param string $ledger_id The UUID of the Ledger to fetch
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view($ledger_id, array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . $ledger_id, $query, $options);

        return $response;
    }

    /**
     * GET /user/{user_id}/ledger/count
     *
     * Get a count of the current number of Ledgers for the current User
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