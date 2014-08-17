<?php


namespace CommonLedger\Sdk\Api\Ledger;


use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;

class Addon extends AbstractEndpoint
{

    private $ledger_id;
    private $endpoint = 'addon';
    private $addon_id;

    /**
     * Create a new Addon endpoint relative to a Ledger
     *
     * @param string $prefix
     * @param string $ledger_id
     * @param string $addon_id
     * @param HttpClient $client
     */
    public function __construct($prefix, $ledger_id, $addon_id, HttpClient $client)
    {
        parent::__construct($client);

        $this->ledger_id = $ledger_id;
        $this->endpoint = sprintf('%s/%s/%s', $prefix, $ledger_id, $this->endpoint);
        $this->addon_id = $addon_id;
    }


    /**
     * GET /ledger/{ledger_id}/addon
     *
     * List the Addons for the current Ledger. These are external tools that connect to the
     * Ledger and push/pull data from the Ledger.
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
     * GET /ledger/{ledger_id}/addon/{addon_id}
     *
     * Get an Addon from the current Ledger by the Addon id
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . $this->addon_id, $query, $options);

        return $response;
    }

    /**
     * GET /ledger/{ledger_id}/addon/count
     *
     * Get a count of the current number of Addons for the current Ledger
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