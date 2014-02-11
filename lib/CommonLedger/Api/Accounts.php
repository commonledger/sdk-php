<?php

namespace CommonLedger\Api;

use CommonLedger\HttpClient\HttpClient;

/**
 * Manages data relating to the Chart of Accounts
 *
 * @param $account_id The account UUID
 */
class Accounts
{

    private $account_id;
    private $client;

    public function __construct($account_id, HttpClient $client)
    {
        $this->account_id = $account_id;
        $this->client = $client;
    }

    /**
     * Creates a new account in the chart of accounts
     *
     */
    public function add(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('account', $body, $options);

        return $response;
    }

    /**
     * Synchronises a set of accounts
     *
     */
    public function sync(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('account/sync', $body, $options);

        return $response;
    }

    /**
     * Get an account from the chart of accounts
     * '/core.account/view/:account_id' GET
     *
     */
    public function view(array $options = array())
    {
        $body = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get('account/'.rawurlencode($this->account_id).'', $body, $options);

        return $response;
    }

    /**
     * Updates an existing account in the chart of accounts
     *
     */
    public function update(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('account/'.rawurlencode($this->account_id).'', $body, $options);

        return $response;
    }

    /**
     * Deletes an account from the chart of accounts
     *
     */
    public function delete(array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());

        $response = $this->client->delete('account/'.rawurlencode($this->account_id), $body, $options);

        return $response;
    }

    /**
     * Get the number of accounts for an organization. Defaults to current organization_id,
     * unless specified in the query
     */
    public function count(array $options = array())
    {
        $body = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get('account/count', $body, $options);

        return $response;
    }

}
