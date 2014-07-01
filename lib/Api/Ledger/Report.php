<?php


namespace CommonLedger\Sdk\Api\Ledger;


use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;

class Report extends AbstractEndpoint
{

    private $ledger_id;
    private $endpoint = 'report';

    /**
     * Create a new Document endpoint relative to a Ledger
     *
     * @param string $prefix
     * @param string $ledger_id
     * @param HttpClient $client
     */
    public function __construct($prefix, $ledger_id, HttpClient $client)
    {
        parent::__construct($client);

        $this->ledger_id = $ledger_id;
        $this->endpoint = sprintf('%s/%s/%s', $prefix, $ledger_id, $this->endpoint);
    }


    /**
     * GET /ledger/{ledger_id}/report
     *
     * List the available Reports for the current Ledger
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
     * GET /ledger/{ledger_id}/report/{report_id}
     *
     * Get a Report from the current Ledger by the Report id
     *
     * @param string $report_id The id of the Report to fetch
     * @param array $options Optional arguments to pass to pass to the request
     *
     * @return \CommonLedger\Sdk\HttpClient\Response
     */
    public function view($report_id, array $options = array())
    {
        $query = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get($this->endpoint . '/' . $report_id, $query, $options);

        return $response;
    }

}