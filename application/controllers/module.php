<?php
class Module extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('crud_model');
	   $this->load->model('datatable_model');
	   $this->load->model('user_model');
	   $this->load->model('notification_model');
	}

	
	public function view_modules()
	{
		$page = 'module_view';
		if ($this->session->userdata('session_user'))//si la session existe
   		{
			if ( ! file_exists(APPPATH.'/views/'.$page.'.php'))
			{
				// Whoops, we don't have a page for that!
				show_404();
			}
			$data['title'] = 'Modules'; 
			$data['infos_user'] = $this->session->userdata('session_user');
			$data['list_user'] = $this->crud_model->getAll('user');
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

	public function ajax_list_modules($id_responsable_module)
	{
		$table = 'view_module';
		$column = array('id','nom_projet','nom_module','avancement_module','date_fin_module','nom_responsable_module');
		$order = array('id' => 'desc');
		$where = array('id_responsable_module' => $id_responsable_module);

		$list = $this->datatable_model->get_datatables($table,$column,$order,$where);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $module) {
			$no++;
			$row = array();
			$row[] = $module->id;
			$row[] = $module->nom_projet;
			$row[] = $module->nom_module;
			$row[] = $module->avancement_module;
			$row[] = $module->date_fin_module;
			$row[] = $module->nom_responsable_module.' '.$module->prenom_responsable_module ;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="View" onclick="goToTache('."'".$module->id."'".')"><i class="glyphicon glyphicon-eye-open"></i> View</a>
			     ';
		
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
		$page = 'module_tache_view';
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
			if( isset($data['module']['id']) && $data['module']['id_responsable_module'] == $data['infos_user']['id']){
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
		$order = array('ide' => 'desc');
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

	public function ajax_edit_module($id)
	{
		$data = $this->crud_model->getById('view_module',$id);
		echo json_encode($data);
	}
	public function ajax_add_module($id_projet)
	{
		$nom_module = $this->input->post('nom_module');
		$id_user = $this->input->post('id_user');
		$data = array(
			    'id_projet' => $id_projet,
				'nom' => $nom_module,
				'id_user' => $id_user,
				
			);
		$insert = $this->crud_model->save('module',$data);
		if($insert === TRUE){
				$projet = $this->crud_model->getById('projet',$id_projet);
				$data = array(
					'id_user' => $id_user,
					'texte' => 'Nouveau Module! Projet :'.$projet['nom'].' / Module : '.$nom_module,
				);
				$this->notification_model->setNotification($data);
				echo json_encode(array("status" => TRUE));
		}else{
				echo json_encode(array("status" => FALSE));
		}
		
	}

	public function ajax_update_module()
	{	
		$id_module = $this->input->post('id_module');
		$nom_module = $this->input->post('nom_module');
		$id_user = $this->input->post('id_user');
		$id_user_initial = $this->input->post('id_user_initial');
		$data = array(
				'nom' => $nom_module,
				'id_user' => $id_user,
			);
		$update = $this->crud_model->update('module', $data,array('id' => $id_module));
		if($update === TRUE){
			if($id_user != $id_user_initial){
				$module = $this->crud_model->getById('view_module',$id_module);
				$data_nouveau_tache = array(
					'id_user' => $id_user,
					'texte' => 'Nouveau Module! Projet :'.$module['nom_projet'].' / Module : '.$module['nom_module'],
				);
				$this->notification_model->setNotification($data_nouveau_tache);// notification nouveau tache
				$data_tache_annule = array(
					'id_user' => $id_user_initial,
					'texte' => 'Module Annulé! Projet :'.$module['nom_projet'].' / Module : '.$module['nom_module'],
				);
				$this->notification_model->setNotification($data_tache_annule);// notification nouveau annulé
			}
			echo json_encode(array("status" => TRUE));
		}else
		{
			echo json_encode(array("status" => FALSE));
		}
	}

	public function ajax_delete_module($id)
	{
		$module = $this->crud_model->getById('view_module',$id);
		$data_tache_annule = array(
				'id_user' => $module['id_responsable_module'],
				'texte' => 'Module Annulée! Projet :'.$module['nom_projet'].' / Module : '.$module['nom_module'],
		);
		$this->notification_model->setNotification($data_tache_annule);// notification tache annule
		$this->crud_model->delete('module',$id);
		echo json_encode(array("status" => TRUE));
	}
	
}
?>