<?php

class sampleImpressumController extends sampleController {

   public function execute(sampleRequest $request, sampleResponse $response) {
      $db = $this->factory->getDatabase(DSN);
      $res = $db->query('select * FROM blog_users');
      $response->users = $res->fetch_all(MYSQLI_ASSOC);
       
      return new sampleStaticView( __DIR__ . '/../pages/impressum.xhtml');
   }
}