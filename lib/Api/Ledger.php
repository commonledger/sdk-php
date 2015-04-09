<?php

namespace CommonLedger\Sdk\Api;

use CommonLedger\Sdk\HttpClient\HttpClient;

class Ledger extends AbstractEndpoint
{

    private $endpoint = 'ledger';
    private $ledger_id;

    /**
     * Set $ledger_id class member variable to be passed to member functions to build the ledger endpoint.
     *
     * @param string $ledger_id The UUID of the Ledger
     * @param HttpClient $client
     */
    public function __construct($ledger_id = 'current', HttpClient $client){

        parent::__construct($client);
        $this->ledger_id = $ledger_id;

    }

    /**
     * GET /ledger
     *
     * Get a list of all Ledgers the current token has access to
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
     * POST /ledger
     *
     * Create a new Ledger
     *
     * @param array $body A key => value array of Ledger properties
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
     * GET /ledger/{ledger_id}
     *
     * Get a Ledger by it's UUID
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . rawurlencode($this->ledger_id), $query, $options);

        return $response;
    }

    /**
     * POST /ledger/{ledger_id}
     *
     * Update the data for a Ledger
     *
     * @param array $body The Ledger data
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function update(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint . '/' . $this->ledger_id, $body, $options);

        return $response;
    }

    /**
     * DELETE /ledger/{ledger_id}
     *
     * Delete a Ledger
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function delete(array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());

        $response = $this->client->delete($this->endpoint . '/' . $this->ledger_id, $body, $options);

        return $response;
    }



    /**
     * GET /ledger/count
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


    /**
     * Get the addon endpoint for a Ledger
     *
     * @param string $addon_id The Addon id for the addon endpoint, this optional id is needed and has to be overloaded
     * if you want to call the 'Addon' class member function 'view'.
     *
     * @return Ledger\Addon
     */
    public function addon($addon_id = 'current')
    {
        return new Ledger\Addon($this->endpoint, $this->ledger_id, $addon_id, $this->client);
    }

    /**
     * Get the chart endpoint for a Ledger
     *
     * @param string $chart_id The Chart id for the chart endpoint, this optional id is needed and has to be overloaded
     * if you want to call the 'Chart' class member functions 'view', 'update', 'delete', 'account', 'tax' and 'journal'.
     *
     * @return Ledger\Chart
     */
    public function chart($chart_id = 'current')
    {
        return new Ledger\Chart($this->endpoint, $this->ledger_id, $chart_id, $this->client);
    }

	/**
	 * Get the user endpoint for a Ledger
	 *
	 * @param string $user_id The User id for the user endpoint, this optional id is needed and has to be overloaded
	 * if you want to call the 'User' class member functions 'view', 'add', 'update', 'delete'.
	 *
	 * @return Ledger\User
	 */
	public function user($user_id = 'current')
	{
		return new Ledger\User($this->endpoint, $this->ledger_id, $user_id, $this->client);
	}

    /**
     * Get the document endpoint for a Ledger
     *
     * @param string $document_id The Document id for the document endpoint, this optional id is needed and has to be
     * overloaded if you want to call the 'Document' class member functions 'view' and 'update'.
     *
     * @return Ledger\Document
     */
    public function document($document_id = null)
    {
        return new Ledger\Document($this->endpoint, $this->ledger_id, $document_id, $this->client);
    }

    /**
     * Get the report endpoint for a Ledger
     *
     * @param string $report_id The Report id for the report endpoint, this optional id is needed and has to be
     * overloaded if you want to call the 'Report' class member functions 'view'.
     *
     * @return Ledger\Report
     */
    public function report($report_id = null)
    {
        return new Ledger\Report($this->endpoint, $this->ledger_id, $report_id, $this->client);
    }

}
