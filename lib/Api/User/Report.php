<?php

namespace CommonLedger\Sdk\Api\User;

use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;

class Report extends AbstractEndpoint
{

    private $user_id;
    private $endpoint = 'report';
    private $report_id;

    /**
     * Create a new Report endpoint relative to a User
     *
     * @param string $prefix
     * @param string $user_id
     * @param string $report_id The id of the Report to fetch
     * @param HttpClient $client
     */
    public function __construct($prefix, $user_id, $report_id, HttpClient $client)
    {
        parent::__construct($client);

        $this->user_id = $user_id;
        $this->endpoint = sprintf('%s/%s/%s', $prefix, $user_id, $this->endpoint);
        $this->report_id = $report_id;
    }


    /**
     * GET /user/{user_id}/report
     *
     * List the available Reports for the current User
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
     * GET /user/{user_id}/report/{report_id}
     *
     * Get a Report from the current User by the Report id
     *
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view(array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . $this->report_id, $query, $options);

        return $response;
    }

}