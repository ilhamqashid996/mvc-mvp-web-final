<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

use \Model\User;
use \Core\Request;
use \Core\Session;

class Login
{
    use MainController;

    public function index()
    {
        $data = [];

        $request = new Request;

        if ($request->posted())
        {
            $user = new User;

            $email = $request->post('email');
            $password = $request->post('password');

            // Check if user data is available
            if ($row_data = $user->select_single_row_data(['email' => $email]))
            {
                // Check is password is correct
                if (password_verify($password, $row_data->password))
                {
                    $session = new Session;
                    $session->auth($row_data);

                    redirect('home');
                }
            }
            
            $user->errors['email'] = "Incorrect email or password. Try again.";
            $data['errors'] = $user->errors;
        }

        $this->view('login', $data);
    }
}
