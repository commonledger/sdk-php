<?php

namespace CommonLedger\Sdk\Api\Ledger;

use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;

class Contact extends AbstractEndpoint
{
    private $ledger_id;
    private $endpoint = 'contact';
    private $contact_id;

    /**
     * Create a new Contact endpoint relative to a Ledger
     *
     * @param string $prefix
     * @param string $ledger_id
     * @param string $contact_id The UUID of the Contact
     * @param HttpClient $client
     */
    public function __construct($prefix, $ledger_id, $contact_id, HttpClient $client)
    {
        parent::__construct($client);

        $this->ledger_id = $ledger_id;
        $this->endpoint = sprintf('%s/%s/%s', $prefix, $ledger_id, $this->endpoint);
        $this->contact_id = $contact_id;
    }


    /**
     * GET /ledger/{ledger_id}/contact
     *
     * List the Contacts for the current Ledger
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
     * POST /ledger/{ledger_id}/contact
     *
     * Create a new Contact on the current Ledger
     *
     * @param array $body A key => value array of Contact properties
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
     * GET /ledger/{ledger_id}/contact/{contact_id}
     *
     * Get a Contact from the current Ledger by the Contact id
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . $this->contact_id, $query, $options);

        return $response;
    }

    /**
     * POST /ledger/{ledger_id}/contact/{contact_id}
     *
     * Update the data for a Contact on the current Ledger
     *
     * @param array $body The Contact data
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function update(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint . '/' . $this->contact_id, $body, $options);

        return $response;
    }

    /**
     * DELETE /ledger/{ledger_id}/contact/{contact_id}
     *
     * Delete the association of a Contact to the current Ledger
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function delete(array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());

        $response = $this->client->delete($this->endpoint . '/' . $this->contact_id, $body, $options);

        return $response;
    }

    /**
     * POST /ledger/{ledger_id}/contact/sync
     *
     * Sync multiple Contact objects with the current Ledger. Uses origin id properties for
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

}