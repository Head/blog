<?php

class sampleErrorController extends sampleController {

	public function execute(sampleRequest $request, sampleResponse $response) {
		$response->trace = debug_backtrace();
		$response->error = 'An Error occoured:';
		return new sampleErrorView();
	}

}