<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_type extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //comunicación con el modelo
        $this->load->model('Mdl_evento_tipo');
    }
    
    /*================================================
    =		       Bloque de comentarios             =
    =       VICTOR SAMAYOA 07/03/2017 16:09     	 =
    Función : index :: Funcion para mostrar vista principal
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function index()
    {
        //listar todos los tipos de evento creados
        $array_obtener_tipos_evento = $this->Mdl_evento_tipo->Evento_tipo_listar();
        //crea array con los datos a mandar a la vista 
        $array_tipos_de_evento      = array();
        foreach ($array_obtener_tipos_evento as $key => $value) {
            $array_datos["event_type_id"] = $value['_id']->{'$id'};
            $array_datos["name"]          = $value['name'];
            $array_datos["status"]        = $value['status'];
            array_push($array_tipos_de_evento, $array_datos);
        }
        
        $data['list_event_types'] = $array_tipos_de_evento;
        
        $this->load->helper('url');
        $this->load->view('listEventType', $data);
    }
    
    /*================================================
    =		       Bloque de comentarios             =
    =       VICTOR SAMAYOA 07/03/2017 16:09     	 =
    Función : index :: Funcion para mostrar vista 
    para crear tipos de evento
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function createEventType()
    {
        $this->load->helper('url');
        $this->load->view('createEventType');
        
    }
    /*================================================
    =		       Bloque de comentarios             =
    =       VICTOR SAMAYOA 07/03/2017 16:09     	 =
    Función : index :: Funcion para mostrar vista 
    para editar tipos de evento
    Parametros : $id : id del evento a editar
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function editEventType($id = NULL)
    {
        if ($id != NULL) {
            //mostrar datos
            $this->load->helper('url');
            
            $array_obtener_tipo_evento = $this->Mdl_evento_tipo->Tipo_evento_editar($id);
            $array_tipo_evento      = $array_obtener_tipo_evento[0];
            //arreglo co datos a enviar a la vista
            $array_tipo_evento_data["event_type_id"] = $array_tipo_evento['_id']->{'$id'};
            $array_tipo_evento_data["name"]          = $array_tipo_evento['name'];
            $array_tipo_evento_data["status"]        = $array_tipo_evento['status'];
            
            $data['eventTypeData'] = $array_tipo_evento_data;
            
            $this->load->view('editEventType', $data);
        } else {
            //regresar a index enviar parametro
            redirect('');
        }
        
    }
    /*================================================
    =		       Bloque de comentarios             =
    =       VICTOR SAMAYOA 09/03/2017 16:09     	 =
    Función : index :: Funcion para eliminar tipo de evento
    Parametros : $id : id del evento a eliminar
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function deleteEvent($id = NULL)
    {
        
        //cambia el status del evento
        $data = array(
            'status' => 0
        );
        
        $this->load->helper('url');
        
        //Transfering data to Model
        $this->Mdl_evento_tipo->deleteEvent($data, $id);
        
        redirect('/events/index', 'refresh');
        
    }
   	/*================================================
    =		       Bloque de comentarios             =
    =       VICTOR SAMAYOA 09/03/2017 16:09     	 =
    Función : index :: Funcion para cambiar status de 
    tipo de evento
    Parametros : $id : id del evento
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/ 
    public function statusEventType($id)
    {
        $array_get_data = $this->input->get();
        
        $status_id = array(
            'status' => $array_get_data["status"]
        );
        
        $this->load->helper('url');
        
        $this->Mdl_evento_tipo->Tipo_evento_estado_editar($status_id, $id);
        
        redirect('/event_type/index', 'refresh');
        
    }
    /*================================================
    =		       Bloque de comentarios             =
    =       VICTOR SAMAYOA 09/03/2017 16:09     	 =
    Función : index :: Funcion para cambiar status de 
    tipo de evento
    Parametros : $id : id del evento
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/ 
    public function updateEventType($id = NULL)
    {
        
        
        $data = array(
            'name' => $this->input->post('name')
        );
        
        $this->load->helper('url');
        
        $sanitize_data = $this->_sanitizeVar($data, true);

        //Transfering data to Model
        $this->Mdl_evento_tipo->Tipo_evento_actualizar($sanitize_data, $id);
        
        redirect('/event_type/index', 'refresh');
        
    }

    /*
    Función: Sanitiza variables o arrays, limpia la variable de caracteres especiales para
    evitar SQL Inyection.
    Parametros: Variable o array de tipo texto
    Devuelve: Variable o array sin caracteres especiales.
    */
     public function _sanitizeVar( $var, $type = false ){
     #type = true for array
     $sanitize = array();
         if ( $type ){
             foreach ($var as $key => $value) {
             $sanitize[$key] = $this->_clearString( $value );
             }
             return $sanitize;
         } else {
             return $this->_clearString( $var );
         }
     }
     private function _clearString( $string ){
     $string = strip_tags($string);
     $string = htmlspecialchars($string);
     $string = addslashes($string);
     #$string = quotemeta($string);
     return $string;
     }
    
    /*================================================
    =		       Bloque de comentarios             =
    =       VICTOR SAMAYOA 09/03/2017 16:09     	 =
    Función : index :: Funcion para guardar tipo de evento
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/ 
    public function saveEventType()
    {
                
        $data = array(
            'name' => $this->input->post('name'),
            'status' => 1
        );
        
        $this->load->helper('url');
        $sanitize_data = $this->_sanitizeVar($data, true);
    
        //Transfering data to Model
        $this->Mdl_evento_tipo->tipo_evento_insertar($sanitize_data);
        
        redirect('/event_type/index', 'refresh');
        
    }
}
