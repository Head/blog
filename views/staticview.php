<?php

class sampleStaticView implements sampleViewInterface {

	protected $staticFile;

	public function __construct($filename) {
		$this->staticFile = $filename;
	}

	public function render(sampleRequest $request, sampleResponse $response) {
		ob_start();
		include $this->staticFile;
		$html = ob_get_clean();
		return $html;
	}

}