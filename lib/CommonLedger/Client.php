<?php

namespace CommonLedger;

use CommonLedger\HttpClient\HttpClient;

class Client
{
    private $httpClient;

    public function __construct($auth = array(), array $options = array())
    {
        $this->httpClient = new HttpClient($auth, $options);
    }

    /**
     * Manages data relating to the Chart of Accounts
     *
     * @param $account_id The account UUID
     */
    public function accounts($account_id)
    {
        return new Api\Accounts($account_id, $this->httpClient);
    }

    /**
     * Collection of different tax rates and their codes
     *
     * @param $tax_id The tax UUID
     */
    public function tax($tax_id)
    {
        return new Api\Tax($tax_id, $this->httpClient);
    }

    /**
     * Manages journal entries and journal lines
     *
     * @param $journal_id The journal entry UUID
     */
    public function journals($journal_id)
    {
        return new Api\Journals($journal_id, $this->httpClient);
    }

}
