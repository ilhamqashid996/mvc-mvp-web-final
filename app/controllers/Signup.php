<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

use \Model\User;
use \Core\Request;

class Signup
{
    use MainController;

    public function index()
    {
        $data = [];

        $request = new Request;

        if ($request->posted())
        {
            $user = new User;

            // Check if user data validated
            if ($user->validate($request->post()))
            {
                // Save to database
                $password = password_hash($request->post('password'), PASSWORD_DEFAULT);
                $request->set('password', $password);
                $request->set('date', date("Y-m-d H:i:s"));
                
                $user->insert($request->post());
                redirect('login');
            }
            
            $data['errors'] = $user->errors;
        }

        $this->view('signup', $data);
    }
}
