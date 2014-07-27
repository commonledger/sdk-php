<?php

namespace CommonLedger\Sdk\Api;


class Ledger extends AbstractEndpoint
{

    private $endpoint = 'ledger';

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
     * @param string $ledger_id The UUID of the Ledger
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view($ledger_id, array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . rawurlencode($ledger_id), $query, $options);

        return $response;
    }

    /**
     * POST /ledger/{ledger_id}
     *
     * Update the data for a Ledger
     *
     * @param string $ledger_id The UUID of the Ledger
     * @param array $body The Ledger data
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function update($ledger_id, array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint . '/' . $ledger_id, $body, $options);

        return $response;
    }

    /**
     * DELETE /ledger/{ledger_id}
     *
     * Delete a Ledger
     *
     * @param string $ledger_id The UUID of the Ledger to delete
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function delete($ledger_id, array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());

        $response = $this->client->delete($this->endpoint . '/' . $ledger_id, $body, $options);

        return $response;
    }

    /**
     * Get the addon endpoint for a Ledger
     *
     * @param string $ledger_id The Ledger id for the addon endpoint
     *
     * @return Ledger\Addon
     */
    public function addon($ledger_id)
    {
        return new Ledger\Addon($this->endpoint, $ledger_id, $this->client);
    }

    /**
     * Get the chart endpoint for a Ledger
     *
     * @param string $ledger_id The Ledger id for the chart endpoint
     *
     * @return Ledger\Chart
     */
    public function chart($ledger_id)
    {
        return new Ledger\Chart($this->endpoint, $ledger_id, $this->client);
    }

    /**
     * Get the document endpoint for a Ledger
     *
     * @param string $ledger_id The Ledger id for the document endpoint
     *
     * @return Ledger\Document
     */
    public function document($ledger_id)
    {
        return new Ledger\Document($this->endpoint, $ledger_id, $this->client);
    }

    /**
     * Get the report endpoint for a Ledger
     *
     * @param string $ledger_id The Ledger id for the report endpoint
     *
     * @return Ledger\Report
     */
    public function report($ledger_id)
    {
        return new Ledger\Report($this->endpoint, $ledger_id, $this->client);
    }

}
