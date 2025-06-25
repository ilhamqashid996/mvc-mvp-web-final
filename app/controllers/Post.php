<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

use \Model\User;
use \Model\Post as PostModel;

use \Core\Session;
use \Core\Pager;

class Post
{
    use MainController;

    public function index($id = null)
    {
        $session = new Session;

        if (!$session->is_logged_in())
        {
            redirect('login');
        }
        
        // Creating pagination
        $limit = 10;
        $data['pager'] = new Pager($limit);
        $offset = $data['pager']->offset;

        $post = new PostModel;

        $data['post'] = $post->find_data(['id' => $id]);

        if ($data['post'])
        {
            $data['post'] = $post->add_user_data($data['post']);
            $data['post'] = $data['post'][0];
        }
        
        $this->view('post', $data);
    }
}
