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
     * '/core.account/add' POST
     *
     */
    public function add(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('core.account/add', $body, $options);

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

        $response = $this->client->get('core.account/view/'.rawurlencode($this->account_id).'', $body, $options);

        return $response;
    }

    /**
     * Updates an existing account in the chart of accounts
     * '/core.account/update/:account_id' POST
     *
     */
    public function update(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('core.account/update/'.rawurlencode($this->account_id).'', $body, $options);

        return $response;
    }

    /**
     * Deletes an account from the chart of accounts
     * '/core.account/delete/:account_id' GET
     *
     */
    public function delete(array $options = array())
    {
        $body = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get('core.account/delete/'.rawurlencode($this->account_id).'', $body, $options);

        return $response;
    }

    /**
     * Synchronises a set of accounts
     * '/core.account/sync' POST
     *
     */
    public function sync(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('core.account/sync', $body, $options);

        return $response;
    }

}
