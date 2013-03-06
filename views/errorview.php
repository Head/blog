<?php

class sampleErrorView implements sampleViewInterface {

   public function render(sampleRequest $request, sampleResponse $response) {
       header('Content-type: text/plain');
       $output = "An Error occoured.\n";
       $output .= print_r($request, true);
       $output .= print_r($response, true);
       return $output;
   }

}