<?php

class sampleLoginController extends sampleController {

    public function execute(sampleRequest $request, sampleResponse $response) {
        
        switch($request->getValue('action')) {
            case 'login':
                if($this->login($request->getValue('username'), $request->getValue('passwd'))) {
                    header('Location: /blog/', 302);
                }else{
                    $response->loginfailed = true;
                }
                break;
            case 'logout':
                $this->logout();
                header('location: /blog/');
                exit;
                break;
        }
        
        return new sampleStaticView(__DIR__ . '/../pages/login.xhtml');
    }
    
    private function login($username, $passwd) {
        if(!$username) return false;
        if(!$passwd) return false;
        
        $db = $this->factory->getDatabase(DSN);
        $res = $db->query(
                'select id, username from blog_users where username="%s" and passwd="%s"', 
                array($username, md5($passwd))
        );
        if ($res->num_rows != 1) {
            return false;
        }else{
            $_SESSION['user'] = $res->fetch_object();
            return true;
        }
    }
    
    private function logout() {
        session_destroy();
    }
    
}
