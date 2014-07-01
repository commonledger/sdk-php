<?php


namespace CommonLedger\Sdk\Exception;

use Exception;

class OAuthException extends Exception {

    public $oauth_params = array();

    public function __construct($message, $code, $oauth_params = array()){
        parent::__construct($message, $code);

        $this->oauth_params = $oauth_params;
    }

}