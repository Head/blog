<?php

class sampleResponse {

	protected $data = array();

	public function __set($key, $value) {
		$this->data[$key] = $value;
	}

	public function __get($key) {
		if (!isset($this->data[$key])) {
			throw new sampleResponseException("Key '$key' does not exist");
		}
		return $this->data[$key];
	}

	public function __isset($key) {
		return isset($this->data[$key]);
	}

}

class sampleResponseException extends Exception {
	
}