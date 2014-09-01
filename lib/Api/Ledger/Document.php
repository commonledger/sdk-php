<?php


namespace CommonLedger\Sdk\Api\Ledger;


use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;

class Document extends AbstractEndpoint
{

    private $ledger_id;
    private $endpoint = 'document';
    private $document_id;

    /**
     * Create a new Document endpoint relative to a Ledger
     *
     * @param string $prefix
     * @param string $ledger_id
     * @param string $document_id The UUID of the Document
     * @param HttpClient $client
     */
    public function __construct($prefix, $ledger_id, $document_id, HttpClient $client)
    {
        parent::__construct($client);

        $this->ledger_id = $ledger_id;
        $this->endpoint = sprintf('%s/%s/%s', $prefix, $ledger_id, $this->endpoint);
        $this->$document_id = $document_id;
    }


    /**
     * GET /ledger/{ledger_id}/document
     *
     * List the Documents for the current Ledger
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
     * POST /ledger/{ledger_id}/document
     *
     * Create a new Document on the current Ledger
     *
     * @param array $body A key => value array of Document properties
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
     * GET /ledger/{ledger_id}/document/{document_id}
     *
     * Get a Document from the current Ledger by the Document id
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . $this->document_id, $query, $options);

        return $response;
    }

    /**
     * POST /ledger/{ledger_id}/document/{document_id}
     *
     * Update the data for a Document on the current Ledger
     *
     * @param array $body The Document data
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function update(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint . '/' . $this->document_id, $body, $options);

        return $response;
    }

    /**
     * DELETE /ledger/{ledger_id}/document/{document_id}
     *
     * Delete the association of a Document to the current Ledger
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function delete(array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());

        $response = $this->client->delete($this->endpoint . '/' . $this->document_id, $body, $options);

        return $response;
    }


}