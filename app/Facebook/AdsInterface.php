<?php namespace Facebook;

interface AdsInterface {
	public function campaign($id);
	public function adSet($id);
	public function ad($id);
	public function get();
}

?>