<?php
/*================================================
=		       Bloque de comentarios             =
=       VICTOR SAMAYOA 02/03/2017 16:09     	 =
Clase : User_Authentication :: Clase para 
autenticación de usuarios
================= MODIFICACIONES =================*/
Class User_Authentication extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        // Load form helper library
        $this->load->helper('form');
        
        // Load form validation library
        $this->load->library('form_validation');
        
        // Load session library
        $this->load->library('session');
        
        // Load database
        $this->load->model('Login_database');
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
        $this->load->view('login_form');
    }
    
    /*================================================
    =		       Bloque de comentarios             =
    =       VICTOR SAMAYOA 05/03/2017 16:09     	 =
    Función : index :: Funcion para mostrar pagina de registro
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function user_registration_show()
    {
        $this->load->view('registration_form');
    }
    
    /*================================================
    =		       Bloque de comentarios             =
    =       VICTOR SAMAYOA 05/03/2017 16:09     	 =
    Función : index :: Funcion para registrar un nuevo usuario
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function new_user_registration()
    {
        
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('email_value', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('registration_form');
        } else {
            $data   = array(
                'user_name' => $this->input->post('username'),
                'user_email' => $this->input->post('email_value'),
                'user_password' => $this->input->post('password')
            );
            $result = $this->Login_database->registration_insert($data);
            if ($result == TRUE) {
                $data['message_display'] = 'Registration Successfully !';
                $this->load->view('login_form', $data);
            } else {
                $data['message_display'] = 'Username already exist!';
                $this->load->view('registration_form', $data);
            }
        }
    }
    
    /*================================================
    =		       Bloque de comentarios             =
    =       VICTOR SAMAYOA 05/03/2017 16:09     	 =
    Función : index :: Funcion para loguear un usuario
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function user_login_process()
    {
        
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->load->helper('url');
        
        if ($this->form_validation->run() == FALSE) {
            if (isset($this->session->userdata['logged_in'])) {
                $this->load->view('admin_page');
            } else {
                $this->load->view('login_form');
            }
        } else {
            $data   = array(
                'username' => $this->input->post('username'),
                'password' => base64_encode($this->input->post('password'))
            );
            $result = $this->Login_database->login($data);
            
            if ($result == true) {
                
                $username = $this->input->post('username');
                $result   = $this->Login_database->read_user_information($username);
                
                if ($result != false) {
                    $session_data = array(
                        'username' => $result[0]["name"],
                        'email' => $result[0]["email"],
                        'admin_user_id' => $result[0]['_id']->{'$id'},
                        'roll_id' => $result[0]["roll_id"]
                        
                    );
                    // Add user data in session
                    $this->load->helper('url');
                    
                    $this->session->set_userdata('logged_in', $session_data);
                    $this->load->view('admin_page');
                }
            } else {
                $data = array(
                    'error_message' => 'Invalid Username or Password'
                );
                $this->load->view('login_form', $data);
            }
        }
        
    }
    
    /*================================================
    =		       Bloque de comentarios             =
    =       VICTOR SAMAYOA 05/03/2017 16:09     	 =
    Función : index :: Funcion para desloguear un usuario
    Parametros : 
    post :
    Devuelve : Rederizacion de vista
    ================= MODIFICACIONES =================
    ==================================================
    =================================================*/
    public function logout()
    {
        
        // Removing session data
        $sess_array = array(
            'username' => ''
        );
        $this->session->unset_userdata('logged_in', $sess_array);
        $data['message_display'] = 'Successfully Logout';
        $this->load->view('login_form', $data);
    }
    
}

?>