<?php

namespace CommonLedger\Sdk\Api;


class User extends AbstractEndpoint
{

    private $endpoint = 'user';

    /**
     * GET /user
     *
     * Get a list of all Users the current token has access to
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
     * POST /user
     *
     * Create a new User
     *
     * @param array $body A key => value array of User properties
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
     * GET /user/{user_id}
     *
     * Get a User by it's UUID
     *
     * @param string $user_id The UUID of the User
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view($user_id, array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . $user_id, $query, $options);

        return $response;
    }

    /**
     * POST /user/{user}
     *
     * Update the data for a User
     *
     * @param string $user_id The UUID of the User
     * @param array $body The User data
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function update($user_id, array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint . '/' . $user_id, $body, $options);

        return $response;
    }

    /**
     * DELETE /user/{user_id}
     *
     * Delete a User
     *
     * @param string $user_id The UUID of the User to delete
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function delete($user_id, array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());

        $response = $this->client->delete($this->endpoint . '/' . $user_id, $body, $options);

        return $response;
    }

    /**
     * Get the addon endpoint for a User
     *
     * @param string $ledger_id The Ledger id for the addon endpoint
     *
     * @return Ledger\Addon
     */
    public function addon($user_id)
    {
        return new User\Addon($this->endpoint, $user_id, $this->client);
    }

    /**
     * Get the chart endpoint for a User
     *
     * @param string $ledger_id The Ledger id for the chart endpoint
     * @return Ledger\Chart
     */
    public function chart($user_id)
    {
        return new User\Chart($this->endpoint, $user_id, $this->client);
    }

    /**
     * Get the document endpoint for a User
     *
     * @param string $ledger_id The Ledger id for the document endpoint
     * @return Ledger\Document
     */
    public function document($user_id)
    {
        return new User\Document($this->endpoint, $user_id, $this->client);
    }

    public function ledger($user_id)
    {
        return new User\Ledger($this->endpoint, $user_id, $this->client);
    }
}
