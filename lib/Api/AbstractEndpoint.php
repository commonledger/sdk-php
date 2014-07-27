<?php


namespace CommonLedger\Sdk\Api;


use CommonLedger\Sdk\HttpClient\HttpClient;

abstract class AbstractEndpoint {

    protected $client;

    public function __construct(HttpClient $client){
        $this->client = $client;
    }

}