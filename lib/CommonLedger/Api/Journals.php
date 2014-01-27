<?php

namespace CommonLedger\Api;

use CommonLedger\Exception\ClientException;
use CommonLedger\HttpClient\HttpClient;

/**
 * Manages journal entries and journal lines
 *
 * @param $journal_id The journal entry UUID
 */
class Journals
{

    private $journal_id;
    private $client;

    public function __construct($journal_id, HttpClient $client)
    {
        $this->journal_id = $journal_id;
        $this->client = $client;
    }

    /**
     * Add a new journal entry
     * '/core.journal/add' POST
     *
     */
    public function add(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('core.journal/add', $body, $options);

        return $response;
    }

    /**
     * View a journal entry
     * '/core.journal/view/:journal_id' GET
     *
     */
    public function view(array $options = array())
    {
        $body = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get('core.journal/view/'.rawurlencode($this->journal_id).'', $body, $options);

        return $response;
    }

    /**
     * Add a new journal entry
     * '/core.journal/update/:journal_id' POST
     *
     */
    public function update(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('core.journal/update/'.rawurlencode($this->journal_id).'', $body, $options);

        return $response;
    }

    /**
     * Synchronises a set of journals and their lines
     * '/core.account/sync' POST
     *
     */
    public function sync(array $body, array $options = array())
    {
        if(isset($options['body']))
            $body = array_merge($body, $options['body']);

        $response = $this->client->post('core.journal/sync', $body, $options);

        return $response;
    }

}
