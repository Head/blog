<?php

class sampleSearchController extends sampleController {

    public function execute(sampleRequest $request, sampleResponse $response) {
        if ($request->getValue('user')) {
            $response->username = $request->getValue('user')->username;
        }
        
        return new sampleStaticView(__DIR__ . '/../pages/search.xhtml');
   }
}
