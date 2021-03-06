<?php


namespace CommonLedger\Sdk\Api\User\Chart;


use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;

class Account extends AbstractEndpoint
{

    private $chart_id;
    private $endpoint = 'account';
    private $account_id;

    /**
     * Create a new Account endpoint relative to a Chart for a User
     *
     * @param string $prefix
     * @param string $chart_id
     * @param HttpClient $client
     */
    public function __construct($prefix, $chart_id, $account_id, HttpClient $client)
    {
        parent::__construct($client);

        $this->chart_id = $chart_id;
        $this->endpoint = sprintf('%s/%s/%s', $prefix, $chart_id, $this->endpoint);
        $this->account_id = $account_id;

    }


    /**
     * GET /user/{user_id}/chart/{chart_id}/account
     *
     * List the Accounts for the current Chart
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
     * POST /user/{user_id}/chart/{chart_id}/account
     *
     * Create a new Account on the current Chart
     *
     * @param array $body A key => value array of Account properties
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
     * GET /user/{user_id}/chart/{chart_id}/account/{account_id}
     *
     * Get an Account from the current Chart by the Account id
     *
     * @param string $account_id The UUID of the Account to fetch
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . $this->account_id, $query, $options);

        return $response;
    }

    /**
     * POST /user/{user_id}/chart/{chart_id}/account/{account_id}
     *
     * Update the data for an Account on the current Chart
     *
     * @param string $account_id The UUID of the Account
     * @param array $body The Account data
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function update(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint . '/' . $this->account_id, $body, $options);

        return $response;
    }

    /**
     * DELETE /user/{user_id}/chart/{chart_id}/account/{account_id}
     *
     * Delete an Account from the current Chart
     *
     * @param string $account_id The UUID of the Account to delete
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function delete(array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());

        $response = $this->client->delete($this->endpoint . '/' . $this->account_id, $body, $options);

        return $response;
    }

   /**
     * POST /user/{user_id}/chart/{chart_id}/account/sync
     *
     * Sync multiple Account objects with the current Chart. Uses origin id properties for
     * collision detection. Primarily used by foreign accounting package Connectors.
     *
     * @param array $body An array of Account data arrays
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
     * GET /user/{user_id}/chart/{chart_id}/acciybt/count
     *
     * Get a count of the current number of Accounts for the current Chart
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
