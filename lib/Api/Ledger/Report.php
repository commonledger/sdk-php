<?php


namespace CommonLedger\Sdk\Api\Ledger;


use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;

class Report extends AbstractEndpoint
{

    private $ledger_id;
    private $endpoint = 'report';
    private $report_id;

    /**
     * Create a new Document endpoint relative to a Ledger
     *
     * @param string $prefix
     * @param string $ledger_id
     * @param string $report_id The id of the Report to fetch, this id is needed and has to be
     * overloaded if you want to call the class member functions 'view'
     * @param HttpClient $client
     */
    public function __construct($prefix, $ledger_id, $report_id = null, HttpClient $client)
    {
        parent::__construct($client);

        $this->ledger_id = $ledger_id;
        $this->endpoint = sprintf('%s/%s/%s', $prefix, $ledger_id, $this->endpoint);
        $this->report_id = $report_id;
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