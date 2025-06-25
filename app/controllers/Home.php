<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

use \Model\User;
use \Model\Post;

use \Core\Session;

class Home
{
    use MainController;

    public function index()
    {
        $session = new Session;

        if (!$session->is_logged_in())
        {
            redirect('login');
        }

        $id = user('id');

        // Get user row data
        $user = new User;
        $data['row'] = $row = $user->select_single_row_data(['id' => $id]);

        if ($data['row'])
        {
            $post = new Post;

            $data['posts'] = $post->find_all();

            if ($data['posts'])
            {
                $data['posts'] = $post->add_user_data($data['posts']);
            }
        }

        $this->view('home', $data);
    }
}
