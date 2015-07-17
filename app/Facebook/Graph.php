<?php 

namespace App\Facebook;

use GuzzleHttp\Client;

abstract class Graph {

	private $apiVersion = 'v2.4';

	private $graphUrl = 'https://graph.facebook.com/';

	private $token;

	private $requestUrl;

	private $objectID;

	private $client;

	private $parameters;

	function __construct() {
		$this->token = env('FACEBOOK_APP_TOKEN');
	}

	public function get() {
		$this->client = new \GuzzleHttp\Client();
		$this->requestUrl = $this->graphUrl . $this->apiVersion . '/';
		return $this;
	}

	public function setObjectID($objectID) {
		$this->objectID = $objectID;
		$this->requestUrl .= $objectID;
	}

	public function insights($parameters = null) {
		$this->requestUrl .= '/insights';
		$this->setParameters($parameters);
		return $this->execute();
	}

	public function execute() {
		$response = $this->client->get($this->requestUrl, ['query' => $this->parameters]);
		return $response->getBody();
	}

	public function setParameters($array) {
		$this->parameters = [];
		if(isset($array)) {
			foreach($array as $key => $value) {
				$this->parameters[$key] = $value;
			}
		}
		$this->parameters['access_token'] = $this->token;
	}

}

?>