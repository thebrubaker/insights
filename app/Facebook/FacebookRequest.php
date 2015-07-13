<?php 

namespace App\Facebook;

use App\Facebook\Graph;

class FacebookRequest extends Graph {

	public function campaign($objectID) {
		$this->setObjectID($objectID);
		return $this;
	}
	public function adSet($objectID) {
		$this->setObjectID($objectID);
		return $this;
	}
	public function ad($objectID) {
		$this->setObjectID($objectID);
		return $this;
	}

}

?>