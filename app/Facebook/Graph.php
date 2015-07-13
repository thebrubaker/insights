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

	public function insights() {
		$this->requestUrl .= '/insights';
		return $this->execute();
	}

	public function execute() {
		$response = $this->client->get($this->requestUrl, ['query' => ['access_token' => $this->token]]);
		return $response->getBody();
	}

}

?>