<?php


namespace CommonLedger\Sdk\Api\Ledger;


use CommonLedger\Sdk\Api\AbstractEndpoint;
use CommonLedger\Sdk\HttpClient\HttpClient;

class User extends AbstractEndpoint
{
	
	private $ledger_id;
	private $endpoint = 'user';
	private $user_id;
	
	/**
	 * Create a new User endpoint relative to a Ledger
	 *
	 * @param string $prefix
	 * @param string $ledger_id
	 * @param string $user_id The UUID of the User
	 * @param HttpClient $client
	 */
	public function __construct($prefix, $ledger_id, $user_id = 'current', HttpClient $client)
	{
		parent::__construct($client);
		
		$this->ledger_id = $ledger_id;
		$this->endpoint = sprintf('%s/%s/%s', $prefix, $ledger_id, $this->endpoint);
		$this->user_id = $user_id;
	}
	
	
	/**
	 * GET /ledger/{ledger_id}/user
	 *
	 * List the Users for the current Ledger
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
	 * POST /ledger/{ledger_id}/user
	 *
	 * Associate an existing User to
	 * the current Ledger
	 *
	 * @param array $body A key => value array of User ID properties
	 * @param array $options Optional arguments to pass to pass to the request
	 *
	 * @return \CommonLedger\Sdk\HttpClient\Response
	 */
	public function add(array $body, array $options = array())
	{
		if(isset($options['body']))
			$body = array_merge($body, $options['body']);
		
		$response = $this->client->post($this->endpoint, $body, $options);
		
		return $response;
	}
	
	/**
	 * GET /ledger/{ledger_id}/user/{user_id}
	 *
	 * Get a User from the current Ledger by the User id, only if they are associated to this ledger. Can be a good way to test if a user has access to a Ledger
	 *
	 * @param array $options Optional arguments to pass to pass to the request
	 *
	 * @return \CommonLedger\Sdk\HttpClient\Response
	 */
	public function view(array $options = array())
	{
		$query = (isset($options['query']) ? $options['query'] : array());
		
		$response = $this->client->get($this->endpoint . '/' . $this->user_id, $query, $options);
		
		return $response;
	}

	/**
	 * POST /ledger/{ledger_id}/user/{user_id}
	 *
	 * Associate a User on the current Ledger
	 *
	 * @param array $body Unused
	 * @param array $options Optional arguments to pass to pass to the request
	 *
	 * @return \CommonLedger\Sdk\HttpClient\Response
	 */
	public function update(array $body, array $options = array())
	{
		if(isset($options['body']))
			$body = array_merge($body, $options['body']);

		$response = $this->client->post($this->endpoint . '/' . $this->user_id, $body, $options);

		return $response;
	}
	
	/**
	 * DELETE /ledger/{ledger_id}/user/{user_id}
	 *
	 * Delete the association of a User to the current Ledger
	 *
	 * @param array $options Optional arguments to pass to pass to the request
	 *
	 * @return \CommonLedger\Sdk\HttpClient\Response
	 */
	public function delete(array $options = array())
	{
		$body = (isset($options['body']) ? $options['body'] : array());
		
		$response = $this->client->delete($this->endpoint . '/' . $this->user_id, $body, $options);
		
		return $response;
	}
	
	/**
	 * GET /ledger/{ledger_id}/user/count
	 *
	 * Get a count of the current number of Users for the current Ledger
	 *
	 * @param array $options Optional arguments to pass to pass to the request
	 *
	 * @return \CommonLedger\Sdk\HttpClient\Response
	 */
	public function count(array $options = array())
	{
		$response = $this->client->get($this->endpoint . '/count', $options);
		
		return $response;
	}
}