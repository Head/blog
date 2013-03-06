<?php

abstract class sampleController {

	protected $factory;

	public function __construct(sampleFactory $factory) {
		$this->factory = $factory;
	}

	abstract public function execute(sampleRequest $request, sampleResponse $response);
}