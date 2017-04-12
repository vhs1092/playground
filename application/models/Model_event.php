<?php

class Model_Event extends CI_Model
{
    
    /* function __construct() {
    parent::__construct();
    $this->load->database();
    }*/
    
    //la función de Select * en sql
    public function selEventType()
    {
        
        $query = $this->mongo_db->get('event_type');
        //retornamos todo los registros de la tabla perfil
        return $query;
    }
    
    /*HUMBERTO HERRADOR: 16/02/2017: 16:37
    MODIFICACION: indexacion de codigo para mejorar el flujo del codigo
    MODIFICACION: En la funcion get_where la consulta es hacia un objectId de mongodb
    par consultar la llave primaria se utiliza "_id"  y no el nombre event_type_id
    no para una cadena normal
    codigo antiguo:{
    $query=$this->mongo_db->get_where('event_type',array('event_type_id' => $id));
    }
    codigo nuevo:{
    $query=$this->mongo_db->get_where('event_type',array('_id' => new MongoId($id));
    } 
    */
    public function selEventTypeSelected($id, $isNull)
    {
        if ($isNull == true) {
            $query = $this->mongo_db->get('event_type');
        } else {
            // $query = $this->db->query("Select * from event_type where event_type_id != $id");
            $query = $this->mongo_db->get_where('event_type', array(
                '_id' => new MongoId($id)
            ));
        }
        //retornamos todo los registros de la tabla perfil
        return $query;
    }
    
    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 15/02/2017 16:09          =
    Función : insert_events :: Funcion para insertar eventos
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/ 
    public function insert_events($data)
    {
        
        $insertResult = $this->mongo_db->insert('event', $data);
        $id = $insertResult->{'$id'};
        $lastId = $id; 
        return $lastId;
        
    }
    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 15/02/2017 16:09          =
    Función : check_complete :: Funcion para verificar eventos 
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/ 
    public function check_complete($lastId)
    {
        //obtener todos los registros de la tabla event
        $query = $this->mongo_db->get_where('event', array(
            '_id' => new \MongoId($lastId)
        ));
          
        $result   = $query;
        $has_null = false;
        
        //obtener todos los registros de la tabla event_slider  
        $get_images = $this->mongo_db->get_where('event_slider', array(
            'event_id' => new \MongoId($lastId)
        ));
        
        $images = $get_images;
        
        if (sizeof($images) == 0) {
            $has_null = true;
        }
        
        foreach ($result[0] as $key => $value) {
            
            if ($key != "recurrent") {
                
                if ($value == "" || $value == null) {
                    $has_null = true;
                }
            }
        }
        
        if ($has_null == true) {
            $data["status"] = 3;
            
            // Where Condition, if any
            $this->mongo_db->where(array(
                '_id' => new MongoId($lastId)
            ));
            
            // Update Data Array
            $this->mongo_db->set($data);
            
            // Set Options
            $option = array(
                'upsert' => true
            );
            
            // Call Update Function
            $this->mongo_db->update('event', $option);
        }
    }
    
    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 18/02/2017 16:09          =
    Función : insert_media :: Funcion para insertar media 
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/ 
    public function insert_media($data)
    {
        
        $insertResult = $this->mongo_db->insert('event_slider', $data);
        
    }
    
    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 18/02/2017 16:09          =
    Función : insert_evento_horario :: Funcion para insertar horarios 
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/ 
    public function insert_evento_horario($data)
    {
        
        $insertResult = $this->mongo_db->insert('evento_horario', $data);
        
    }
    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 18/02/2017 16:09          =
    Función : delete_horarios :: Funcion para elimnar horarios 
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function delete_horarios($update_id)
    {
        $id = new \MongoId($update_id);
        
        $this->mongo_db->where('event_id', $id);
        $this->mongo_db->delete('evento_horario');
        
    }
    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 18/02/2017 16:09          =
    Función : listEventos :: Funcion para listar eventos 
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function listEventos($user)
    {
        
        $query = $this->mongo_db->get_where('event', array(
            'admin_user' => new MongoId($user)
        ));
        return $query;
    }
    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 18/02/2017 16:09          =
    Función : getEventMedia :: Funcion para obtener media 
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function getEventMedia($id)
    {
        
        $query = $this->mongo_db->get_where('event_slider', array(
            'event_id' => new MongoId($id)
        ));

        return $query;
    }
    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 20/02/2017 16:09          =
    Función : getHorarios :: Funcion para obtener horarios 
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/    
    public function getHorarios($id)
    {
        
        $query = $this->mongo_db->get_where('evento_horario', array(
            'event_id' => new MongoId($id)
        ));

        return $query;
    }
    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 20/02/2017 16:09          =
    Función : updateEvent :: Funcion para actualizar eventos 
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/  
    public function updateEvent($data, $id)
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
        $this->mongo_db->update('event', $option);
        $has_null = false;
         
        //obtener todos los registros de la tabla event
        $query = $this->mongo_db->get_where('event', array(
            '_id' => new \MongoId($id)
        ));
        
        $result   = $query;
        $has_null = false;
        
        //obtener todos los registros de la tabla event_slider  
        $get_images = $this->mongo_db->get_where('event_slider', array(
            'event_id' => new \MongoId($id)
        ));
        
        $images = $get_images;
        
        if (sizeof($images) == 0) {
            
            $has_null = true;
            
        }
        
        foreach ($result[0] as $key => $value) {
            
            if ($key != "recurrent") {
                
                if ($value == "" || $value == null) {
                    $has_null = true;
                }
                
                
            }
        }
        
        if ($has_null == true) {
            $data["status"] = 3;
            
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
            $this->mongo_db->update('event', $option);
        } else {
            $data["status"] = 1;
            
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
            $this->mongo_db->update('event', $option);
            
        }
        
    }
    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 20/02/2017 16:09          =
    Función : deleteEvent :: Funcion para eliminar eventos 
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/ 
    public function deleteEvent($data, $id)
    {
        $data["status"] = 2;
        
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
        $this->mongo_db->update('event', $option);
        
        
    }
    
    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 20/02/2017 16:09          =
    Función : updateEventSlider :: Funcion para actualizar media 
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/ 
    public function updateEventSlider($data, $id)
    {
        
        $this->db->where('event_id', $id);
        $this->db->update('event_slider', $data);
        
    }
    
    
}