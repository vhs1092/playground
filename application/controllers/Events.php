<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //comunicación con el modelo
        $this->load->model('Model_event');
    }
    
    /*================================================
    =               Bloque de comentarios             =
    =       VICTOR SAMAYOA 13/02/2017 16:09          =
    Función : index :: Funcion para listar los eventos
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function index()
    {
        $this->load->library('session');
        
        $sess        = $this->session->all_userdata();
        $roll_id     = $sess['logged_in']['roll_id'];
        $usuario_id  = $sess['logged_in']['admin_user_id'];
        $listEventos = $this->Model_event->listEventos($usuario_id);
        
        $ev = array();
        foreach ($listEventos as $key => $value) {
            $array_evento['event_id']      = $value['_id']->{'$id'};
            $array_evento['name']          = $value['name'];
            $array_evento['event_type_id'] = $value['event_type_id'];
            $array_evento['admin_user']    = $value['admin_user'];
            $array_evento['description']   = $value['description'];
            $array_evento['event_source']  = $value['event_source'];
            $array_evento['longitude']     = $value['longitude'];
            $array_evento['latitude']      = $value['latitude'];
            $array_evento['price']         = $value['price'];
            $array_evento['recurrent']     = $value['recurrent'];
            $array_evento['status']        = $value['status'];
            array_push($ev, $array_evento);
        }
        
        $data['listEventos'] = $ev;
        $this->load->helper('url');
        $this->load->view('listEvent', $data);
    }
    
    /*================================================
    =               Bloque de comentarios             =
    =       VICTOR SAMAYOA 16/02/2017 18:10          =
    Función : index :: Funcion para listar los eventos
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function createEvent()
    {
        $query_tipo_evento = $this->Model_event->selEventType();
        
        $array_tipo_evento = array();
        foreach ($query_tipo_evento as $key => $value) {
            $data["event_type_id"] = $value['_id']->{'$id'};
            $data["name"]          = $value['name'];
            array_push($array_tipo_evento, $data);
        }
        
        $data['selEventType'] = $array_tipo_evento;
        $this->load->helper('url');
        $this->load->view('createEvent', $data);
        
        
    }
    
   
    /*================================================
    =               Bloque de comentarios             =
    =       VICTOR SAMAYOA 18/02/2017 16:09          =
    Función : index :: Funcion para leer archivo csv
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function uploadCsv()
    {
        
        //valida si viene el archivo    
        if ($_FILES['csv']['size'] > 0) {
            
            //get the csv file 
            $file = $_FILES['csv']['tmp_name'];
            
            //cargar libreria de session para almacenar variables
            $this->load->library('session');
            
            $arreglo_session = $this->session->all_userdata();
            $roll_id         = $arreglo_session["logged_in"]["roll_id"];
            $usuario_id      = $arreglo_session["logged_in"]["usuario_id"];
            
            
            $arr  = array();
            $flag = true;
            if (($handle = fopen($file, "r")) !== FALSE) {
                while (($row = fgetcsv($handle, 0, ",")) !== FALSE) {
                    
                    //código para no leer la primer fila del archivo csv
                    if ($flag) {
                        $flag = false;
                        continue;
                    }
                    
                    if ($row[1] == 0) {
                        $row[1] = null;
                    } else {
                        $row[1] = new \MongoId($row[1]);
                    }
                    
                    
                    $arreglo_datos = array(
                        'name' => $row[0],
                        'event_type_id' => $row[1],
                        'description' => $row[2],
                        'event_source' => $row[7],
                        'price' => $row[8],
                        'latitude' => $row[9],
                        'longitude' => $row[10],
                        'recurrent' => $row[11],
                        'status' => 1,
                        'admin_user' => new \MongoId($usuario_id)
                    );
                    
                    //insertar evento
                    $evento_id = $this->Model_event->insert_events($arreglo_datos);
                    //verificar si el evento esta completo
                    $this->Model_event->check_complete($evento_id);
                    
                }
                fclose($handle);
            }
            
        }
        $this->load->helper('url');
        
        redirect('/events/index', 'refresh');
        
    }
    
    /*================================================
    =               Bloque de comentarios             =
    =       VICTOR SAMAYOA 20/02/2017 16:09          =
    Función : index :: Funcion para editar evento
    Parametros : id del evento a editar
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function editEvent($id = NULL)
    {
        if ($id != NULL) {
            //mostrar datos
            $this->load->helper('url');
            
            //obtener informacion del evento seleccionado
            $array_informacion_evento = $this->mongo_db->get_where('event', array(
                '_id' => new \MongoId($id)
            ));
            $array_evento_data        = $array_informacion_evento[0];
            
            //obtener informacion del tipo de evento seleccionado
            $event_type_selected = $this->Model_event->selEventTypeSelected($array_evento_data['event_type_id']->{'$id'}, false);
            $event_type_name     = $event_type_selected[0]["name"];
            
            //obtener array de tipos de evento
            $event_type  = $this->Model_event->selEventType();
            $event_types = array();
            foreach ($event_type as $key => $value) {
                $data["event_type_id"] = $value['_id']->{'$id'};
                $data["name"]          = $value['name'];
                array_push($event_types, $data);
            }
            
            //obtener imagenes/videos del evento    
            $event_files             = $this->Model_event->getEventMedia($id);
            $array_evento_multimedia = array();
            foreach ($event_files as $key => $value) {
                $data2["type"]  = $value["type"];
                $data2["value"] = $value['value'];
                array_push($array_evento_multimedia, $data2);
            }
            
            //obtener horarios
            $horarios       = $this->Model_event->getHorarios($id);
            $array_horarios = array();
            foreach ($horarios as $key => $value) {
                $data_horarios["fecha_inicio"] = $value["fecha_inicio"];
                $data_horarios["fecha_fin"]    = $value["fecha_fin"];
                $data_horarios["hora_inicio"]  = $value["hora_inicio"];
                $data_horarios["hora_fin"]     = $value["hora_fin"];
                array_push($array_horarios, $data_horarios);
            }
            //llenar arreglo de datos
            $array_evento["selEventType"]    = $event_types;
            $array_evento["event_type_name"] = $event_type_name;
            $array_evento["event_id"]        = $array_evento_data['_id']->{'$id'};
            $array_evento["name"]            = $array_evento_data['name'];
            $array_evento["event_type_id"]   = $array_evento_data['event_type_id']->{'$id'};
            $array_evento["event_type_id"]   = $array_evento_data['event_type_id']->{'$id'};
            $array_evento["admin_user"]      = $array_evento_data['admin_user']->{'$id'};
            $array_evento["description"]     = $array_evento_data['description'];
            $array_evento["event_source"]    = $array_evento_data['event_source'];
            $array_evento["longitude"]       = $array_evento_data['longitude'];
            $array_evento["latitude"]        = $array_evento_data['latitude'];
            $array_evento["price"]           = $array_evento_data['price'];
            $array_evento["recurrent"]       = $array_evento_data['recurrent'];
            $array_evento["status"]          = $array_evento_data['status'];
            $array_evento['eventMedia']      = $array_evento_multimedia;
            $array_evento['evento_horarios'] = $array_horarios;
            
            $this->load->view('editEvent', $array_evento);
        } else {
            //regresar a index enviar parametro
            redirect('');
        }
        
    }
    
    /*================================================
    =               Bloque de comentarios             =
    =       VICTOR SAMAYOA 21/02/2017 16:09          =
    Función : index :: Funcion para elimar evento
    Parametros : id del evento a eliminar
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function deleteEvent($id = NULL)
    {
        
        $data = array(
            'status' => 0
        );
        
        $this->load->helper('url');
        
        //Transfering data to Model
        $insert = $this->Model_event->deleteEvent($data, $id);
        
        redirect('/events/index', 'refresh');
        
    }
    
    /*================================================
    =               Bloque de comentarios             =
    =       VICTOR SAMAYOA 22/02/2017 16:09          =
    Función : index :: Funcion para actualizar evento
    Parametros : id del evento a actualizar
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function updateEvent($id = NULL)
    {
        
        $POST = $this->input->post();
        
        if ($this->input->post('recurrent') == null) {
            $recurrent = 0;
        } else {
            $recurrent = 1;
        }
        
        
        $event_type_id = $this->input->post('event_type_id');
        
        if ($event_type_id == 0) {
            $event_type_id = null;
        } else {
            $event_type_id = new \MongoId($event_type_id);
        }
        
        $data = array(
            'name' => $this->input->post('name'),
            'event_type_id' => $event_type_id,
            'description' => $this->input->post('description'),
            'event_source' => $this->input->post('event_source'),
            'longitude' => $this->input->post('longitude'),
            'latitude' => $this->input->post('latitude'),
            'price' => $this->input->post('price'),
            'recurrent' => $recurrent
        );
        
        $this->load->helper('url');
        
        $sanitize_data = $this->_sanitizeVar($data, true);
        
        //Transfering data to Model
        $insert = $this->Model_event->updateEvent($sanitize_data, $id);
        
        $lastId = $id;
        
        $delete = $this->Model_event->delete_horarios($lastId);
        
        //delete horarios
        
        
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin    = $this->input->post('fecha_fin');
        $hora_inicio  = $this->input->post('hora_inicio');
        $hora_fin     = $this->input->post('hora_fin');
        
        if ($fecha_inicio[0] != "") {
            $total = count($fecha_inicio);
            
            if ($total > 0) {
                for ($i = 0; $i < $total; $i++) {
                    
                    $array_evento_horario = array(
                        'fecha_inicio' => $fecha_inicio[$i],
                        'fecha_fin' => $fecha_fin[$i],
                        'hora_inicio' => $hora_inicio[$i],
                        'hora_fin' => $hora_fin[$i],
                        'event_id' => new \MongoId($lastId)
                        
                    );
                    $sanitize_data        = $this->_sanitizeVar($array_evento_horario, true);
                    
                    $insert = $this->Model_event->insert_evento_horario($sanitize_data);
                }
            }
        }
        
        
        
        $j = 0; //Variable for indexing uploaded image 
        if ($_FILES['file']['name'][0] != "") {
            
            $target_path = "uploads/"; //Declaring Path for uploaded images
            for ($i = 0; $i < count($_FILES['file']['name']); $i++) { //loop to get individual element from the array
                
                
                if ($_FILES['file']['type'][$i] == "video/mp4" || $_FILES['file']['type'][$i] == "video/flv" || $_FILES['file']['type'][$i] == "video/mov") {
                    
                    $validextensions = array(
                        "mp4",
                        "flv",
                        "mov"
                    ); //Extensions which are allowed
                    $type            = "video";
                } else {
                    $validextensions = array(
                        "jpeg",
                        "jpg",
                        "png"
                    ); //Extensions which are allowed
                    $type            = "image";
                    
                }
                $ext            = explode('.', basename($_FILES['file']['name'][$i])); //explode file name from dot(.) 
                $file_extension = end($ext); //store extensions in the variable
                
                $generateRandom = "";
                $generateRandom = md5(uniqid()) . "." . $ext[count($ext) - 1];
                $target_pathF   = $target_path . $generateRandom; //set the target path with a new name of image
                $j              = $j + 1; //increment the number of uploaded images according to the files in array       
                
                $data = array(
                    'type' => $type,
                    'value' => $generateRandom,
                    'event_id' => $lastId
                );
                
                $insert = $this->Model_event->insert_media($data);
                
                if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_pathF)) { //if file moved to uploads folder
                    
                } else { //if file was not moved.
                    echo $j . ').<span id="error">please try again!.</span><br/><br/>';
                }
                
            }
            
            
        }
        
        redirect('/Events/index', 'refresh');
        
    }
    
    /*================================================
    =               Bloque de comentarios             =
    =       VICTOR SAMAYOA 23/02/2017 16:09          =
    Función : index :: Funcion para guardar evento
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function saveEvent()
    {
        
        $this->load->library('session');
        
        $array_session = $this->session->all_userdata();
        $roll_id       = $array_session["logged_in"]["roll_id"];
        $usuario_id    = $array_session["logged_in"]["admin_user_id"];
        
        if ($this->input->post('recurrent') == null) {
            $recurrent = 1;
        } else {
            $recurrent = 0;
        }
        
        
        $tipo_evento_id = $this->input->post('event_type_id');
        
        if ($tipo_evento_id == 0) {
            $tipo_evento_id = null;
        }
        
        
        
        $array_evento_data = array(
            'name' => $this->input->post('name'),
            'event_type_id' => new \MongoId($tipo_evento_id),
            'admin_user' => new \MongoId($usuario_id),
            'description' => $this->input->post('description'),
            'event_source' => $this->input->post('event_source'),
            'longitude' => $this->input->post('longitude'),
            'latitude' => $this->input->post('latitude'),
            'price' => $this->input->post('price'),
            'recurrent' => $recurrent,
            'status' => 1
        );
        
        $this->load->helper('url');
        $sanitize_data = $this->_sanitizeVar($array_evento_data, true);
        
        //Transfering data to Model
        $id = $this->Model_event->insert_events($sanitize_data);
        
        $lastId = $id;
        
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin    = $this->input->post('fecha_fin');
        $hora_inicio  = $this->input->post('hora_inicio');
        $hora_fin     = $this->input->post('hora_fin');
        
        if ($fecha_inicio[0] != "") {
            $total = count($fecha_inicio);
            
            if ($total > 0) {
                for ($i = 0; $i < $total; $i++) {
                    
                    $array_evento_horario = array(
                        'fecha_inicio' => $fecha_inicio[$i],
                        'fecha_fin' => $fecha_fin[$i],
                        'hora_inicio' => $hora_inicio[$i],
                        'hora_fin' => $hora_fin[$i],
                        'event_id' => new \MongoId($lastId)
                        
                    );
                    $sanitize_data        = $this->_sanitizeVar($array_evento_horario, true);
                    
                    $insert = $this->Model_event->insert_evento_horario($sanitize_data);
                }
            }
        }
        
        
        $j = 0; //Variable for indexing uploaded image 
        if ($_FILES['file']['name'][0] != "") {
            
            $target_path = "uploads/"; //Declaring Path for uploaded images
            for ($i = 0; $i < count($_FILES['file']['name']); $i++) { //loop to get individual element from the array
                
                
                if ($_FILES['file']['type'][$i] == "video/mp4" || $_FILES['file']['type'][$i] == "video/flv" || $_FILES['file']['type'][$i] == "video/mov") {
                    
                    $validextensions = array(
                        "mp4",
                        "flv",
                        "mov"
                    ); //Extensions which are allowed
                    $type            = "video";
                } else {
                    $validextensions = array(
                        "jpeg",
                        "jpg",
                        "png"
                    ); //Extensions which are allowed
                    $type            = "image";
                    
                }
                $ext            = explode('.', basename($_FILES['file']['name'][$i])); //explode file name from dot(.) 
                $file_extension = end($ext); //store extensions in the variable
                
                $generateRandom = "";
                $generateRandom = md5(uniqid()) . "." . $ext[count($ext) - 1];
                $target_pathF   = $target_path . $generateRandom; //set the target path with a new name of image
                $j              = $j + 1; //increment the number of uploaded images according to the files in array       
                
                $array_evento_data = array(
                    'type' => $type,
                    'value' => $generateRandom,
                    'event_id' => new \MongoId($lastId)
                );
                
                $insert = $this->Model_event->insert_media($array_evento_data);
                
                if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_pathF)) { //if file moved to uploads folder
                    
                } else { //if file was not moved.
                    echo $j . ').<span id="error">please try again!.</span><br/><br/>';
                }
                
            }
            
            
        }
        
        $this->Model_event->check_complete($lastId);
        
        redirect('/events/index', 'refresh');
        
    }
    /*
    Función: Sanitiza variables o arrays, limpia la variable de caracteres especiales para
    evitar SQL Inyection.
    Parametros: Variable o array de tipo texto
    Devuelve: Variable o array sin caracteres especiales.
    */
    public function _sanitizeVar($var, $type = false)
    {
        #type = true for array
        $sanitize = array();
        if ($type) {
            foreach ($var as $key => $value) {
                $sanitize[$key] = $this->_clearString($value);
            }
            return $sanitize;
        } else {
            return $this->_clearString($var);
        }
    }
    private function _clearString($string)
    {
        $string = strip_tags($string);
        $string = htmlspecialchars($string);
        $string = addslashes($string);
        #$string = quotemeta($string);
        return $string;
    }
}