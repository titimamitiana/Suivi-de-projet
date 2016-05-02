<?php
class Projet extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('crud_model');
	   $this->load->model('datatable_model');
	   $this->load->model('user_model');
	   $this->load->model('notification_model');
	}
	public function view_projets()
	{
		$page = 'projet_view';
		if ($this->session->userdata('session_user'))//si la session existe
   		{
			if ( ! file_exists(APPPATH.'/views/'.$page.'.php'))
			{
				// Whoops, we don't have a page for that!
				show_404();
			}
			$data['title'] = 'Mes Projets'; 
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

	public function ajax_list_projet($id_responsable_projet)
	{
		$table = 'view_projet';
		$column = array('id','nom_projet','avancement_projet','date_debut_projet','date_fin_projet');
		$order = array('id' => 'desc');
		$where = array('id_responsable_projet' => $id_responsable_projet);

		$list = $this->datatable_model->get_datatables($table,$column,$order,$where);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $projet) {
			$no++;
			$row = array();
			$row[] = $projet->id;
			$row[] = $projet->nom_projet;
			$row[] = $projet->avancement_projet;
			$row[] = $projet->date_debut_projet;
			$row[] = $projet->date_fin_projet;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="View" onclick="goToModule('."'".$projet->id."'".')"><i class="glyphicon glyphicon-eye-open"></i> View</a>
			     <a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_mes_projets('."'".$projet->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_mes_projets('."'".$projet->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
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
	
	public function ajax_edit_projet($id)
	{
		$data = $this->crud_model->getById('projet',$id);
		echo json_encode($data);
	}

	public function ajax_add_projet()
	{
		$nom_projet = $this->input->post('nom_projet');
		$date_debut = $this->input->post('date_debut');
		$date_fin = $this->input->post('date_fin');
		$id_user = $this->input->post('id_user');
		$data = array(
				'nom' => $nom_projet,
				'date_debut' => $date_debut,
				'date_fin' => $date_fin,
				'id_user' => $id_user,
				
			);
		$insert = $this->crud_model->save('projet',$data);
		if($insert === TRUE){
				$data = array(
					'id_user' => $id_user,
					'texte' => 'Nouveau Projet! Projet :'.$nom_projet.' ,Date début : '.$date_debut.' ,Date Fin : '.$date_fin,
				);
				$this->notification_model->setNotification($data);// notification
				echo json_encode(array("status" => TRUE));
		}
		else
		{
				echo json_encode(array("status" => FALSE));
		}
		
	}

	public function ajax_update_projet()
	{
		$data = array(
				'nom' => $this->input->post('nom_projet'),
				'date_debut' => $this->input->post('date_debut'),
				'date_fin' => $this->input->post('date_fin'),
				'id_user' => $this->input->post('id_user'),
			);
		$this->crud_model->update('projet', $data , array('id' => $this->input->post('id')));
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete_projet($id)
	{
		$projet = $this->crud_model->getById('projet',$id);
		$data_tache_annule = array(
				'id_user' => $projet['id_user'],
				'texte' => 'Projet Annulé! Projet :'.$projet['nom'],
		);
		$this->notification_model->setNotification($data_tache_annule);// notification tache annule
		$this->crud_model->delete('projet',$id);
		echo json_encode(array("status" => TRUE));
	}

	public function view_modules($id_projet)
	{
		$page = 'projet_module_view';
		if ($this->session->userdata('session_user'))//si la session existe
   		{
			if ( ! file_exists(APPPATH.'/views/'.$page.'.php'))
			{
				// Whoops, we don't have a page for that!
				show_404();
			}
			$data['title'] = 'Modules'; 
			$data['infos_user'] = $this->session->userdata('session_user');
			$data['projet'] = $this->crud_model->getById('projet',$id_projet);
			if( isset($data['projet']['id_user']) && $data['projet']['id_user'] == $data['infos_user']['id']){
				$data['projet_id'] = $id_projet;
				$data['list_user'] = $this->crud_model->getAll('user');
				$this->load->view('layout/header', $data);
				$this->load->view(''.$page, $data);
				$this->load->view('layout/footer');
			}
			else
			{
				show_404();
			}
			
		 }
		 else
	   	 {
		 	//If no session, redirect to login page
		     redirect(URL.'login', 'refresh');//si la session n'existe pas
	    }
	}

	public function ajax_list_module($id_projet)
	{
		$table = 'view_module';
		$column = array('id','nom_module','avancement_module','date_fin_module','nom_responsable_module');
		$order = array('id' => 'desc');
		$where = array('id_projet' => $id_projet);

		$list = $this->datatable_model->get_datatables($table,$column,$order,$where);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $module) {
			$no++;
			$row = array();
			$row[] = $module->id;
			$row[] = $module->nom_module;
			$row[] = $module->avancement_module;
			$row[] = $module->date_fin_module;
			$row[] = $module->nom_responsable_module.' '.$module->prenom_responsable_module ;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="View" onclick="goToTache('."'".$module->id."'".')"><i class="glyphicon glyphicon-eye-open"></i> View</a>
			     <a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_mes_projets_module('."'".$module->id."'".');"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_mes_projets_module('."'".$module->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
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
	
	public function view_taches($id_module)
	{
		$page = 'projet_tache_view';
		if ($this->session->userdata('session_user'))//si la session existe
   		{
			if ( ! file_exists(APPPATH.'/views/'.$page.'.php'))
			{
				// Whoops, we don't have a page for that!
				
			}
			$data['title'] = 'Taches'; 
			$data['module_id'] = $id_module;
			$data['infos_user'] = $this->session->userdata('session_user');
			$data['module'] = $this->crud_model->getById('view_module',$id_module);
			if( isset($data['module']['id']) && $data['module']['id_responsable_projet'] == $data['infos_user']['id']){
				$data['list_user'] = $this->crud_model->getAll('user');
				$this->load->view('layout/header', $data);
				$this->load->view(''.$page, $data);
				$this->load->view('layout/footer');
			}
			else{
				show_404();
			}
			
		 }
		 else
	   	 {
		 	//If no session, redirect to login page
		     redirect(URL.'login', 'refresh');//si la session n'existe pas
	    }
	}

	public function ajax_list_tache($id_module)
	{
		$table = 'view_tache';
		$column = array('id','nom_tache','temps_passe','estimation','reste_a_faire','avancement_tache','depassement','date_fin_tache','nom_responsable_tache');
		$order = array('id' => 'desc');
		$where = array('id_module' => $id_module);

		$list = $this->datatable_model->get_datatables($table,$column,$order,$where);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $tache) {
			$no++;
			$row = array();
			$row[] = $tache->id;
			$row[] = $tache->nom_tache;
			$row[] = $tache->estimation;
			$row[] = $tache->temps_passe;
			$row[] = $tache->reste_a_faire;
			$row[] = $tache->avancement_tache;
			$row[] = $tache->depassement;
			$row[] = $tache->date_fin_tache;
			$row[] = $tache->nom_responsable_tache.' '.$tache->prenom_responsable_tache ;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_mes_projets_tache('."'".$tache->id."'".');"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_mes_projets_tache('."'".$tache->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
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
	
}
?>