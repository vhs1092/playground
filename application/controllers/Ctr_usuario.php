<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*================================================
=		       Bloque de comentarios             =
=       VICTOR SAMAYOA 03/03/2017 16:09     	 =
Clase : Ctr_usuario :: Clase manejo de usuarios
================= MODIFICACIONES =================*/
class Ctr_usuario extends CI_Controller {
   function __construct() {
        parent::__construct();
        //comunicación con el modelo
        $this->load->model('Model_usuario');
    }   

    /*================================================
    =		       Bloque de comentarios             =
    =       VICTOR SAMAYOA 02/03/2017 16:09     	 =
    Función : index :: Funcion para mostrar vista principal
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
	public function index()
	{

		$arreglo_usuarios = $this->Model_usuario->listUsuario();	
		
		$users = array();	
		foreach ($arreglo_usuarios as $key => $value) {
			$data["admin_user_id"] = $value['_id']->{'$id'};
			$data["name"] = $value['name'];
			$data["email"] = $value['email'];
			$data["roll_id"] = $value['roll_id'];

			array_push($users, $data);
		
			}	

		$data['arreglo_usuarios'] = $users;	
	
		$this->load->helper('url'); 
		$this->load->view('listUsers', $data);
	}	
	/*================================================
    =		       Bloque de comentarios             =
    =       VICTOR SAMAYOA 02/03/2017 16:09     	 =
    Función : UsuarioCrear :: Funcion para crear usuario
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
	public function UsuarioCrear()
	{	
        $this->load->helper('url'); 
		$this->load->view('createUser');

	}
	/*================================================
    =		       Bloque de comentarios             =
    =       VICTOR SAMAYOA 02/07/2017 16:09     	 =
    Función : UsuarioEditar :: Funcion para editar usuario
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
	public function UsuarioEditar($id = NULL)
	{
		    if($id != NULL){
            //mostrar datos
   	        $this->load->helper('url'); 
            
            $user_data = $this->Model_usuario->editUser($id);
            $user = $user_data[0];

            $data1["admin_user_id"] = $user['_id']->{'$id'};
			$data1["name"] = $user['name'];
			$data1["password"] = base64_decode($user['password']);
			$data1["email"] = $user['email'];
			$data1["roll_id"] = $user['roll_id'];

			$data['userData'] = $data1;

            $this->load->view('editUser', $data);
        }else{
            //regresar a index enviar parametro
            redirect('');
        }
	
	}
	/*================================================
    =		       Bloque de comentarios             =
    =       VICTOR SAMAYOA 02/07/2017 16:09     	 =
    Función : UsuarioEditar :: Funcion eliminar usuario
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
	public function UsuarioEliminar($id = NULL)
	{
	
		$data = array(
		'status' => 0
		);
		
		$this->load->helper('url'); 

		//Transfering data to Model
		$insert = $this->Model_event_type->deleteEvent($data, $id);
			
    	redirect('/events/index', 'refresh');
	
	}
	/*
	public function statusEventType($id){
		$GET = $this->input->get();

		$data = array(
		'status' => $GET["status"]
		);

 		$this->load->helper('url');

		$insert = $this->Model_event_type->updateEventType2($data, $id);

		redirect('/event_type/index', 'refresh');

	}*/	

	/*================================================
    =		       Bloque de comentarios             =
    =       VICTOR SAMAYOA 02/07/2017 16:09     	 =
    Función : UsuarioActualizar :: Funcion actualizar usuario
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
	public function UsuarioActualizar($id = NULL){


		$POST = $this->input->post();
		$data = array(
		'name' => $this->input->post('name'),
		'password' => base64_encode($this->input->post('password')),
		'email' => $this->input->post('email'),
		'roll_id' => $this->input->post('roll_id')
		);

 		$this->load->helper('url');
 		//sanitizar data
 		$sanitize_data = $this->_sanitizeVar($data, true);

		//Transfering data to Model
		$insert = $this->Model_usuario->updateUser($sanitize_data, $id);
			
    	redirect('/Ctr_usuario/index', 'refresh');

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
    =       VICTOR SAMAYOA 02/07/2017 16:09     	 =
    Función : saveUser :: Funcion guardar usuario
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
	public function UsuarioGuardar(){


		$POST = $this->input->post();
		$data = array(
		'name' => $this->input->post('name'),
		'password' => base64_encode($this->input->post('password')),
		'email' => $this->input->post('email'),
		'roll_id' => $this->input->post('roll_id')
		);

		$sanitize_data = $this->_sanitizeVar($data, true);
		$this->load->helper('url');

		//Transfering data to Model
		$insert = $this->Model_usuario->insert_usuario($sanitize_data);
			
    	redirect('/Ctr_usuario/index', 'refresh');

	}
}
