<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

use \Core\Session;

class Logout
{
    use MainController;

    public function index()
    {
        $session = new Session;
        $session->logout();

        redirect('login');
    }
}
