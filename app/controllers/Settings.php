<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

use \Core\Session;

class Settings
{
    use MainController;

    public function index()
    {
        $session = new Session;

        if (!$session->is_logged_in())
        {
            redirect('login');
        }
        
        $this->view('settings');
    }
}
