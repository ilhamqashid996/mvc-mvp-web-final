<?php 

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

Trait Model
{
    use Database;

    public $limit = 10;
    public $offset = 0;

    public $order_type = "desc";
    public $order_column = "id";

    public $errors = [];

    public function find_all()
    {
        $string = "select * from $this->table order by $this->order_column $this->order_type limit $this->limit offset $this->offset";
        return $this->run_query($string);
    }

    public function find_data($data, $n_data = [])
    {
        $keys = array_keys($data);
        $n_keys = array_keys($n_data);
        
        // $query = "select * from $this->table where id = :id && name = :name && age != :age";
        $string = "select * from $this->table where ";
        
        foreach ($keys as $key)
        {
            $string .= $key . " = :" . $key . " && ";
        }
        foreach ($n_keys as $key)
        {
            $string .= $key . " != :" . $key . " && ";
        }

        $string = trim($string, " && ");
        $string .= " order by $this->order_column $this->order_type limit $this->limit offset $this->offset";
        
        $data = array_merge($data, $n_data);

        return $this->run_query($string, $data);
    }
    
    public function select_single_row_data($data, $n_data = [])
    {
        $keys = array_keys($data);
        $n_keys = array_keys($n_data);
        
        // $query = "select * from $this->table where id = :id && name = :name && age != :age";
        $string = "select * from $this->table where ";
        
        foreach ($keys as $key)
        {
            $string .= $key . " = :" . $key . " && ";
        }
        foreach ($n_keys as $key)
        {
            $string .= $key . " != :" . $key . " && ";
        }

        $string = trim($string, " && ");
        $string .= " limit $this->limit offset $this->offset";
        
        $data = array_merge($data, $n_data);

        $result = $this->run_query($string, $data);
        if ($result)
            return $result[0];

        return false;
    }

    public function insert($data)
    {
        /** Remove unwanted data **/
        if (!empty($this->allowed_columns))
        {
            foreach ($data as $key => $value)
            {
                if (!in_array($key, $this->allowed_columns))
                {
                    unset($data[$key]);
                }
            }
        }
        
        $keys = array_keys($data);

        // $query = "insert into $this->table (name,age,date) values (:name,:age,:date)";
        $query = "insert into $this->table (" . implode(",", $keys) . ") values (:" . implode(",:", $keys) . ")";
        
        $this->run_query($query, $data);
        return false;
    }

    public function update($id, $data, $id_column = 'id')
    {
        /** Remove unwanted data **/
        if (!empty($this->allowed_columns))
        {
            foreach ($data as $key => $value)
            {
                if (!in_array($key, $this->allowed_columns))
                {
                    unset($data[$key]);
                }
            }
        }
        
        $keys = array_keys($data);
        
        // $query = "update $this->table set name = :name, age = :age where id = :id";
        $string = "update $this->table set ";
        
        foreach ($keys as $key)
        {
            $string .= $key . " = :" . $key . ", ";
        }

        $string = trim($string, ", ");
        $string .= " where $id_column = :$id_column ";

        $data[$id_column] = $id;
        $this->run_query($string, $data);

        return false;
    }

    public function delete($id, $id_column = 'id')
    {
        $data[$id_column] = $id;

        // $query = "delete from $this->table where id = :id ";
        $string = "delete from $this->table where $id_column = :$id_column ";
                
        $this->run_query($string, $data);

        return false;
    }
}
