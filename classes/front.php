<?php

class sampleFrontController {

	protected $factory;
	protected $request;
	protected $response;

	public function __construct(sampleRequest $request, sampleResponse $response, sampleFactory $factory) {
		$this->request = $request;
		$this->response = $response;
		$this->factory = $factory;
	}

	public function execute($controllerName) {
		$controller = $this->factory->getController($controllerName);
		return $controller->execute($this->request, $this->response);
	}

}