<?php


namespace CommonLedger\Sdk\Api\User;


use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;

class Addon extends AbstractEndpoint
{

    private $user_id;
    private $endpoint = 'addon';
    private $addon_id;

    /**
     * Create a new Addon endpoint relative to a User
     *
     * @param string $prefix
     * @param string $user_id
     * @param string $addon_id
     * @param HttpClient $client
     */
    public function __construct($prefix, $user_id, $addon_id = 'current', HttpClient $client)
    {
        parent::__construct($client);

        $this->user_id = $user_id;
        $this->endpoint = sprintf('%s/%s/%s', $prefix, $user_id, $this->endpoint);
        $this->addon_id = $addon_id;
    }


    /**
     * GET /user/{user_id}/addon
     *
     * List the Addons for the current User. These are external tools that connect on behalf
     * of a User and push/pull data.
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
     * GET /user/{user_id}/addon/{addon_id}
     *
     * Get an Addon from the current User by the Addon id
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
     * GET /user/{user_id}/addon/count
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