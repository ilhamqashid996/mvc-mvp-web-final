<?php 

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

class Post
{
    use Model;

    protected $table = 'posts';
    protected $allowed_columns = [
        'image', 'user_id', 'post', 'description', 'price', 'date'
    ];

    public function add_user_data($rows)
    {
        foreach ($rows as $key => $row)
        {
            $result = $this->get_single_row_query("select * from users where id = :id", ['id'=>$row->user_id]);
            $rows[$key]->user = $result;
        }

        return $rows;
    }

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['post']))
        {
            $this->errors['post'] = "Please type something to post";
        }

        if (empty($this->errors))
        {
            return true;
        }
        return false;
    }

    public function create_table()
    {
        $query = "
            create table if not exists posts
            (
                id int unsigned primary key auto_increment,
                user_id int unsigned,
                post text null,
                image varchar(1024) null,
                date datetime null,

                key user_id (user_id),
                key date (date)
            )
        ";

        $this->run_query($query);
    }
}
