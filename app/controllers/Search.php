<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

use \Model\User;
use \Core\Session;


class Search
{
    use MainController;

    public function index()
    {
        $session = new Session;

        if (!$session->is_logged_in())
        {
            redirect('login');
        }

        $data = [];

        $user = new User;

        $arr = [];
        $arr['find'] = $_GET['find'] ?? null;

        if ($arr['find'])
        {
            $arr['find'] = "%" . $arr['find'] . "%";
            $data['rows'] = $user->run_query("select * from users where username like :find || email like :find", $arr);
        }
        
        $this->view('search', $data);
    }
}
