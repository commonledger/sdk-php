<?php

namespace CommonLedger\Sdk\Api;

use CommonLedger\Sdk\HttpClient\HttpClient;

class User extends AbstractEndpoint
{
    private $user_id;
    private $endpoint = 'user';

    /**
     * Set $user_id class member variable to be passed to member functions to build the user endpoint.
     *
     * @param string $user_id, , this id is needed if calling the member functions 'view',
     * 'update', 'delete', 'addon', 'chart', 'document' and 'report' and 'ledger'.
     * @param HttClient $client
     */
    public function __construct($user_id = 'current', HttpClient $client){

        parent::__construct($client);
        $this->user_id = $user_id;

    }

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
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . $this->user_id, $query, $options);

        return $response;
    }

    /**
     * POST /user/{user}
     *
     * Update the data for a User
     *
     * @param array $body The User data
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function update(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint . '/' . $this->user_id, $body, $options);

        return $response;
    }

    /**
     * DELETE /user/{user_id}
     *
     * Delete a User
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function delete(array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());

        $response = $this->client->delete($this->endpoint . '/' . $this->user_id, $body, $options);

        return $response;
    }

    /**
     * Get the addon endpoint for a User
     *
     * @param string $addon_id The Addon id for the addon endpoint, this optional id is needed and has to be overloaded
     * if you want to call the 'Addon' class member function 'view'.
     *
     * @return User\Addon
     */
    public function addon($addon_id = 'current')
    {
        return new User\Addon($this->endpoint, $this->user_id, $addon_id, $this->client);
    }

    /**
     * Get the chart endpoint for a User
     *
     * @param string $chart_id The Chart id for the chart endpoint, this optional id is needed and has to be overloaded
     * if you want to call the 'Chart' class member functions 'view', 'update', 'delete', 'account', 'tax' and 'map'.
     * @return User\Chart
     */
    public function chart($chart_id = 'current')
    {
        return new User\Chart($this->endpoint, $this->user_id, $chart_id, $this->client);
    }

    /**
     * Get the document endpoint for a User
     *
     * @param string $document_id The Document id for the document endpoint, this optional id is needed and has to be
     * overloaded if you want to call the 'Document' class member functions 'view' and 'update'.
     * @return User\Document
     */
    public function document($document_id = null)
    {
        return new User\Document($this->endpoint, $this->user_id, $document_id, $this->client);
    }

    /**
     * Get the ledger endpoint for a User
     *
     * @param $ledger_id The Ledger id for the ledger endpoint, this optional id is needed and has to be overloaded
     * if you want to call the 'Ledger' class member functions 'view'.
     * @return User\Ledger
     */
    public function ledger($ledger_id = 'current')
    {
        return new User\Ledger($this->endpoint, $this->user_id, $ledger_id, $this->client);
    }

    /**
     * Get the map endpoint of a User
     *
     * @param string $map_id The Map UUID for the map endpoint, this optional id is needed if you
     * want to call the 'Map' class member functions 'view', 'update' and 'delete'.
     * @return User\Map
     */
    public function map($map_id = null)
    {
        return new User\Map($this->endpoint, $this->user_id, $map_id, $this->client);
    }

    /**
     * Get the report endpoint for a User
     *
     * @param string $report_id The Report id for the report endpoint, this optional id is needed and has to be
     * overloaded if you want to call the 'Report' class member functions 'view'.
     *
     * @return User\Report
     */
    public function report($report_id = null)
    {
        return new User\Report($this->endpoint, $this->user_id, $report_id, $this->client);
    }

}
