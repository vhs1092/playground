<?php

class Model_Usuario extends CI_Model
{
    
    /* function __construct() {
    parent::__construct();
    $this->load->database();
    }*/
    
    //la función de Select * en sql
    public function selEventType()
    {
        
        $query = $this->db->query("Select * from event_type");
        //retornamos todo los registros de la tabla perfil
        return $query->result();
    }
    
    //funcion para insertar usuario
    public function insert_usuario($data)
    {
        
        $this->mongo_db->insert('admin_user', $data);
        
        
    }
    
    //funcion para insertar media
    public function insert_media($data)
    {
        
        $this->db->insert('event_slider', $data);
        
    }
    
    //funcion para listar usuarios
    public function listUsuario()
    {
        $query = $this->mongo_db->get('admin_user');
        
        return $query;
    }
    
    public function editUser($id)
    {
        
        $query = $this->mongo_db->get_where('admin_user', array(
            '_id' => new \MongoId($id)
        ));
        
        return $query;
    }
    public function getEventMedia($id)
    {
        $consulta = $this->db->query("SELECT * FROM event_slider WHERE event_id = $id");
        return $consulta->result();
    }
    
    
    public function updateUser($data, $id)
    {
        
        // Where Condition, if any
        $this->mongo_db->where(array(
            '_id' => new MongoId($id)
        ));
        
        // Update Data Array
        $this->mongo_db->set($data);
        
        // Set Options
        $option = array(
            'upsert' => true
        );
        
        // Call Update Function
        $this->mongo_db->update('admin_user', $option);
        
    }
    
    
    public function updateEventType2($data, $id)
    {
        
        $this->db->where('event_type_id', $id);
        $this->db->update('event_type', $data);
        
    }
    public function deleteEvent($data, $id)
    {
        
        $this->db->where('event_id', $id);
        $this->db->update('event', $data);
        
    }
    
    
    public function updateEventSlider($data, $id)
    {
        
        $this->db->where('event_id', $id);
        $this->db->update('event_slider', $data);
        
    }
    
    
}