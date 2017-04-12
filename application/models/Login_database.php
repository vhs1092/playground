<?php

Class Login_Database extends CI_Model
{
    
    // Insert registration data in database
    public function registration_insert($data)
    {
        
        // Query to check whether username already exist or not
        $condition = "user_name =" . "'" . $data['user_name'] . "'";
        $this->db->select('*');
        $this->db->from('user_login');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            
            // Query to insert data in database
            $this->db->insert('user_login', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            }
        } else {
            return false;
        }
    }
    
    // Read data using username and password
    public function login($data)
    {
        
        
        $query = $this->mongo_db->get_where('admin_user', array(
            'email' => $data["username"],
            'password' => $data["password"]
        ));
        
        if (sizeof($query) > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    // Read data from database to show data in admin page
    public function read_user_information($username)
    {
        
        $query = $this->mongo_db->get_where('admin_user', array(
            'email' => $username
        ));
        
        if (sizeof($query) > 0) {
            return $query;
        } else {
            return false;
        }
    }
    
}

?>