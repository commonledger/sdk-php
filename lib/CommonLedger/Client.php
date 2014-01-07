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

}
