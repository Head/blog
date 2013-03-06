<?php

class sampleFactory {

	protected $defaultController = 'sampleErrorController';

	public function setDefaultController($default) {
		$this->defaultController = $default;
	}

	public function getController($name) {
		$name = 'sample' . ucfirst($name) . 'Controller';
		if (!class_exists($name)) {
			return new $this->defaultController($this);
		}
		return new $name($this);
	}

	public function getDatabase($dsn) {
		return new sampleDatabase($dsn);
	}

}