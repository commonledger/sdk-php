<?php

namespace CommonLedger\Api;

use CommonLedger\HttpClient\HttpClient;

/**
 * Manage users
 *
 * @param string $user_id The account UUID
 */
class Users
{

    private $user_id;
    private $client;

    public function __construct($user_id, HttpClient $client)
    {
        $this->user_id = $user_id;
        $this->client = $client;
    }

    /**
     * Get the user associated with the current token
     * '/core.account/add' POST
     *
     */
    public function current(array $options = array())
    {
        $query = isset($options['query']) ?  $options['query'] : array();
        $response = $this->client->get('user/current', $query, $options);

        return $response;
    }

    /**
     * Get a user by their UUID
     * '/core.account/add' POST
     *
     */
    public function get(array $options = array())
    {
        $query = isset($options['query']) ?  $options['query'] : array();
        $response = $this->client->get('user/'.rawurlencode($this->user_id), $query, $options);

        return $response;
    }

}
