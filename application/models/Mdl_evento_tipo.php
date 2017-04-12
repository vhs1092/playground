<?php

class Mdl_evento_tipo extends CI_Model {

   /* function __construct() {
        parent::__construct();
        $this->load->database();
    }*/
    

    
    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 09/03/2017 16:09          =
    Función : index :: Funcion para insertar tipo de 
    evento
    Parametros : $array de datos
    post :
    Devuelve : 
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/ 
    public function tipo_evento_insertar($data){

    $this->mongo_db->insert('event_type',$data); 
           
    }

    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 07/03/2017 16:09          =
    Función : index :: Funcion para listart tipos de evento
    Parametros : $array de datos
    post :
    Devuelve : 
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/ 
    public function Evento_tipo_listar(){
       $query = $this->mongo_db->get('event_type');

      return $query;
    }

    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 03/03/2017 16:09          =
    Función : index :: Funcion para editar tipos de 
    evento
    Parametros : $id a editar
    post :
    Devuelve : 
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/ 
    public function Tipo_evento_editar($id){

        $query=$this->mongo_db->get_where('event_type', 
            array('_id' => new \MongoId($id))
        );

        return $query;
    }

    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 03/03/2017 16:09          =
    Función : index :: Funcion para actualizar tipos de 
    evento
    Parametros : $id a editar
    post :
    Devuelve : 
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/ 
   public function Tipo_evento_actualizar($data, $id){
    
      // Where Condition, if any
    $this->mongo_db->where(array('_id' => new MongoId($id)));

    // Update Data Array
    $this->mongo_db->set($data); 

    // Set Options
    $option = array('upsert' => true);

    // Call Update Function
    $this->mongo_db->update('event_type', $option);
   
    }
    
    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 03/03/2017 16:09          =
    Función : index :: Funcion para actualizar estado
    Parametros : $id a editar
    post :
    Devuelve : 
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
   public function Tipo_evento_estado_editar($data, $id){
    
    $this->db->where('event_type_id', $id);
    $this->db->update('event_type', $data);
    
    }
    
    /*================================================
    =              Bloque de comentarios             =
    =       VICTOR SAMAYOA 03/03/2017 16:09          =
    Función : index :: Funcion para borrar tipos de evento
    Parametros : $id a eliminar
    post :
    Devuelve : 
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function deleteEvent($data, $id){
    
    $this->db->where('event_id', $id);
    $this->db->update('event', $data);
    
    }


}