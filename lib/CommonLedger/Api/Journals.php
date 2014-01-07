<?php

namespace CommonLedger\Api;

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
     * @param $organisation_id The UUID of the organisation this journal entry belongs to
     * @param $journal_number The journal number this journal entry belongs to
     * @param $journal_type The type of journal entry this is
     * @param $datetime The timestamp this journal entry was recorded
     * @param $notes Any notes this journal entry has
     * @param $lines An array of journal lines that make up this journal entry
     */
    public function add($organisation_id, $journal_number, $journal_type, $datetime, $notes, $lines, array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());
        $body['organisation_id'] = $organisation_id;
        $body['journal_number'] = $journal_number;
        $body['journal_type'] = $journal_type;
        $body['datetime'] = $datetime;
        $body['notes'] = $notes;
        $body['lines'] = $lines;

        $response = $this->client->post('/core.journal/add', $body, $options);

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

        $response = $this->client->get('/core.journal/view/'.rawurlencode($this->journal_id).'', $body, $options);

        return $response;
    }

    /**
     * Add a new journal entry
     * '/core.journal/update/:journal_id' POST
     *
     * @param $organisation_id The UUID of the organisation this journal entry belongs to
     * @param $journal_number The journal number this journal entry belongs to
     * @param $journal_type The type of journal entry this is
     * @param $datetime The timestamp this journal entry was recorded
     * @param $notes Any notes this journal entry has
     * @param $lines An array of journal lines that make up this journal entry
     */
    public function update($organisation_id, $journal_number, $journal_type, $datetime, $notes, $lines, array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());
        $body['organisation_id'] = $organisation_id;
        $body['journal_number'] = $journal_number;
        $body['journal_type'] = $journal_type;
        $body['datetime'] = $datetime;
        $body['notes'] = $notes;
        $body['lines'] = $lines;

        $response = $this->client->post('/core.journal/update/'.rawurlencode($this->journal_id).'', $body, $options);

        return $response;
    }

}
