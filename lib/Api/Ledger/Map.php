<?php
namespace CommonLedger\Sdk\Api\Ledger;


use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;

class Map extends AbstractEndpoint
{

    private $ledger_id;
    private $endpoint = 'map';
    private $map_id;

    /**
     * Create a new Map endpoint relative to a Chart for a User
     *
     * @param string $prefix
     * @param string $ledger_id
     * @param string $map_id
     * @param HttpClient $client
     */
    public function __construct($prefix, $ledger_id, $map_id, HttpClient $client)
    {
        parent::__construct($client);

        $this->ledger_id = $ledger_id;
        $this->endpoint = sprintf('%s/%s/%s', $prefix, $ledger_id, $this->endpoint);
        $this->map_id = $map_id;
    }


    /**
     * GET /ledger/{ledger_id}/map
     *
     * List the Maps for the current Chart
     *
     * @param array $options
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function index(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint, $query, $options);

        return $response;
    }

    /**
     * POST /ledger/{ledger_id}/map/sync
     *
     * Sync multiple Map objects.
     *
     * @param array $body An array of Map data arrays
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function sync(array $body, array $options = array())
    {
        if (isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint . '/sync', $body, $options);

        return $response;
    }

    /**
     * POST /ledger/{ledger_id}/map
     *
     * Create a new Map on the current Chart
     *
     * @param array $body A key => value array of Map properties
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function add(array $body, array $options = array())
    {
        if (isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint, $body, $options);

        return $response;
    }

    /**
     * GET /ledger/{ledger_id}/map/{map_id}
     *
     * Get an Map from the current Chart by the Map id
     *
     * @param string $map_id The UUID of the Map to fetch
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . $this->map_id, $query, $options);

        return $response;
    }

    /**
     * POST /ledger/{ledger_id}/map/{map_id}
     *
     * Update the data for an Map on the current Chart
     *
     * @param string $map_id The UUID of the Map
     * @param array $body The Map data
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function update(array $body, array $options = array())
    {
        if (isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post($this->endpoint . '/' . $this->map_id, $body, $options);

        return $response;
    }

    /**
     * DELETE /ledger/{ledger_id}/map/{map_id}
     *
     * Delete an Map from the current Chart
     *
     * @param string $map_id The UUID of the Map to delete
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function delete(array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());

        $response = $this->client->delete($this->endpoint . '/' . $this->map_id, $body, $options);

        return $response;
    }

    /**
     * GET /ledger/{ledger_id}/map/count
     *
     * Get a count of the current number of Maps for the current Chart
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
     * GET /ledger/{ledger_id}/map/suggest
     *
     * Suggest mappings
     *
     * @param array $options
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function suggest(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/suggest', $query, $options);

        return $response;
    }

}
