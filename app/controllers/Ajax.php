<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

use \Model\User;
use \Model\Post;
use \Model\Image;

use \Core\Request;
use \Core\Session;

class Ajax
{
    use MainController;

    public function index()
    {
        $session = new Session;

        if (!$session->is_logged_in())
        {
            die;
        }

        $request = new Request;
        $user = new User();

        $info['message'] = "";
        $info['success'] = false;

        if ($request->posted())
        {
            $data_type = $request->input('data_type');
            $info['data_type'] = $data_type;

            if ($data_type == 'profile-image')
            {
                $image_row = $request->files('image');

                if ($image_row['error'] == 0)
                {
                    $folder = "uploads/";
                    if (!file_exists($folder))
                    {
                        mkdir($folder, 0777, true);
                    }

                    $destination = $folder . time() . $image_row['name'];
                    move_uploaded_file($image_row['tmp_name'], $destination);

                    $image_class = new Image;
                    $image_class->resize($destination, 1000);

                    $id = user('id');
                    $row = $user->select_single_row_data(['id' => $id]);
                    
                    if (file_exists($row->image))
                        unlink($row->image);

                    $user->update($id, ['image'=>$destination]);

                    $info['message'] = "Profile image changed successfully";
                    $info['success'] = true;
                }
            }
            else if ($data_type == 'create-post')
            {
                $id = user('id');

                $image_row = $request->files('image');

                if (!empty($image_row['name']) && $image_row['error'] == 0)
                {
                    $folder = "uploads/";
                    if (!file_exists($folder))
                    {
                        mkdir($folder, 0777, true);
                    }

                    $destination = $folder . time() . $image_row['name'];
                    move_uploaded_file($image_row['tmp_name'], $destination);

                    $image_class = new Image;
                    $image_class->resize($destination, 1000);
                }

                $post = new Post;

                $arr = [];
                $arr['user_id'] = $id;
                $arr['image'] = $destination ?? '';
                $arr['post'] = $request->input('post');
                $arr['description'] = $request->input('description');
                $arr['price'] = $request->input('price');
                $arr['date'] = date("Y-m-d H:i:s");

                $post->insert($arr);

                $info['message'] = "Post created successfully";
                $info['success'] = true;
            }
            
            echo json_encode($info);
        }
    }
}
