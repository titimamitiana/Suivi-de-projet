<?php
class User extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('user_model','',TRUE);
        $this->load->model('datatable_model');
        $this->load->model('crud_model');
	   
	}
	
	public function login()
	{
		if ( ! $this->session->userdata('session_user'))//si la session existe
   		{
			$page = 'login';
			if ( ! file_exists(APPPATH.'/views/'.$page.'.php'))
			{
				// Whoops, we don't have a page for that!
				show_404();
			}
		
			$data['title'] = ucfirst($page); // Capitalize the first letter
			$this->load->view(''.$page, $data);
		 }
		 else
	   	 {
		 	//If no session, redirect to login page
		     redirect(URL.'home', 'refresh');//si la session n'existe pas
	     }
	}
	
	public function check_user()
	{
		 $login = $this->input->post('login');
		 $password = $this->input->post('password');
		 //query the database
		 $result = $this->user_model->login($login, $password);
		 if ($result)
		 {
					 $session = array(
						 'id' => $result->id,
						 'nom' => $result->nom,
						 'prenom' => $result->prenom,
						 'fonction' => $result->fonction,
						 'statut' => $result->statut,
						 'login' => $result->login,
						 'password' => $result->password,
					 );
					  
					 $this->session->set_userdata('session_user', $session);
					 
					 echo TRUE; 
		}
		else
		{
			 echo 'Invalid username or password';
		}
	}
	
	function logout()
	{
	   $this->session->unset_userdata('session_user');
	   session_unset();//detruire session
	   redirect(URL.'login', 'refresh');
	}

    public function view_users()
    {
        $page = 'users_view';
        if ($this->session->userdata('session_user'))//si la session existe
        {
            if ( ! file_exists(APPPATH.'/views/'.$page.'.php'))
            {
                // Whoops, we don't have a page for that!
                show_404();
            }
            $data['title'] = 'All users';
            $data['infos_user'] = $this->session->userdata('session_user');
            $this->load->view('layout/header', $data);
            $this->load->view(''.$page, $data);
            $this->load->view('layout/footer');
        }
        else
        {
            //If no session, redirect to login page
            redirect(URL.'login', 'refresh');//si la session n'existe pas
        }
    }

    public function ajax_list_users()
    {
        $table = 'user';
        $column = array('id','nom','prenom','statut','login');
        $order = array('id' => 'desc');
        $where = array('id >' => '1');

        $list = $this->datatable_model->get_datatables($table,$column,$order,$where);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) {
            $no++;
            $row = array();
            $row[] = $user->id;
            $row[] = $user->nom;
            $row[] = $user->prenom;
            $row[] = ($user->statut == 1)?'Administrateur':'Utilisateur';
            $row[] = $user->login;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_user('."'".$user->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_user('."'".$user->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->datatable_model->count_all($table,$where),
            "recordsFiltered" => $this->datatable_model->count_filtered($table,$column,$order,$where),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit_user($id)
    {
        $data = $this->crud_model->getById('user',$id);
        echo json_encode($data);
    }

    public function ajax_add_user()
    {
        $nom = $this->input->post('nom');
        $prenom = $this->input->post('prenom');
        $login = $this->input->post('login');
        $mdp = $this->input->post('password');
        $fonction = $this->input->post('fonction');
        $statut = $this->input->post('statut');
        $data = array(
            'nom' => $nom,
            'prenom' => $prenom,
            'fonction' => $fonction,
            'statut' => $statut,
            'login' => $login,
            'password' => MD5($mdp)
        );
        $insert = $this->crud_model->save('user',$data);
        if($insert === TRUE){
            echo json_encode(array("status" => TRUE));
        }
        else
        {
            echo json_encode(array("status" => FALSE));
        }

    }

    public function ajax_update_user()
    {
        $data = array(
            'nom' => $this->input->post('nom'),
            'prenom' => $this->input->post('prenom'),
            'fonction' => $this->input->post('fonction'),
            'statut' => $this->input->post('statut'),
            'login' => $this->input->post('login'),
            'password' => $this->input->post('password'),
        );
        $this->crud_model->update('user', $data , array('id' => $this->input->post('id')));
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete_user($id)
    {
        $this->crud_model->delete('user',$id);
        echo json_encode(array("status" => TRUE));
    }
}
?>