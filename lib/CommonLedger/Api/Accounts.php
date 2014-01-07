<?php

namespace CommonLedger\Api;

use CommonLedger\HttpClient\HttpClient;

/**
 * Manages data relating to the Chart of Accounts
 *
 * @param $account_id The account UUID
 */
class Accounts
{

    private $account_id;
    private $client;

    public function __construct($account_id, HttpClient $client)
    {
        $this->account_id = $account_id;
        $this->client = $client;
    }

    /**
     * Creates a new account in the chart of accounts
     * '/core.account/add' POST
     *
     * @param $organisation_id The organisation the account belongs to
     * @param $account_number The account code
     * @param $name The account name
     * @param $classification The account classification
     * @param $type The type of classification for the account
     * @param $tax The tax code that applies to the account
     * @param $currency The currency code that applies to the account
     */
    public function add($organisation_id, $account_number, $name, $classification, $type, $tax, $currency, array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());
        $body['organisation_id'] = $organisation_id;
        $body['account_number'] = $account_number;
        $body['name'] = $name;
        $body['classification'] = $classification;
        $body['type'] = $type;
        $body['tax'] = $tax;
        $body['currency'] = $currency;

        $response = $this->client->post('/core.account/add', $body, $options);

        return $response;
    }

    /**
     * 
     * '/core.account/view/:account_id' GET
     *
     */
    public function view(array $options = array())
    {
        $body = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get('/core.account/view/'.rawurlencode($this->account_id).'', $body, $options);

        return $response;
    }

}
