<?php

class sampleRequest {

	protected $input;
	protected $params;

	public function __construct(Array $request, Array $session) {
		$this->input = $request;
		$this->session = $session;
	}

	public function setParams(Array $params) {
		$this->params = $params;
	}

	public function getValue($key) {
		if (isset($this->input[$key])) {
			return $this->input[$key];
		}

		if (isset($this->session[$key])) {
			return $this->session[$key];
		}

		if (isset($this->params[$key])) {
			return $this->params[$key];
		}

		return null;
	}

}