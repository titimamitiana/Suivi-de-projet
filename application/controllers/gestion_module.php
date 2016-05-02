<?php
class Gestion_module extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('gestion_projet_model');
	    $this->load->model('crud_model');
	    $this->load->model('datatable_model');
	   $this->load->model('user_model');
	   $this->load->model('notification_model');
	}

	public function view_modules()
	{
		$page = 'gestion_projet_module_view';
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

	public function ajax_projet_list_module()
	{
		$table = 'view_module';
		$column = array('id','id','nom_projet','nom_module','avancement_module','date_fin_module','nom_responsable_module');
		$order = array('id' => 'desc');
		$where = array();

		$list = $this->datatable_model->get_datatables($table,$column,$order,$where);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $module) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="id_module[]" value="'.$module->id.'">';
			$row[] = $module->id;
			$row[] = $module->nom_projet;
			$row[] = $module->nom_module;
			$row[] = $module->avancement_module;
			$row[] = $module->date_fin_module;
			$row[] = $module->nom_responsable_module.' '.$module->prenom_responsable_module ;

			//add html for action
			$row[] = '<button type="button" class="btn btn-success" onclick="add_tache('."'".$module->id."'".')"><i class="glyphicon glyphicon-plus"></i> Add Tache</button>
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


	public function ajax_list_module_my_filter()
	{
		$data['infos_user'] = $this->session->userdata('session_user');
		$json = file_get_contents('Filtre/Module/'.$data['infos_user']['id'].'.json');
		$str = str_replace(array('"','"','[',']'),"",$json);
		$arr = explode(',', $str);

		$table = 'view_module';
		$column = array('id','id','nom_projet','nom_module','avancement_module','date_fin_module','nom_responsable_module');
		$order = array('id' => 'desc');
		$where = array();
		$where_in = $arr;

		$list = $this->datatable_model->get_datatables_where_in($table,$column,$order,$where,$where_in);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $module) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="id_module[]" value="'.$module->id.'">';
			$row[] = $module->id;
			$row[] = $module->nom_projet;
			$row[] = $module->nom_module;
			$row[] = $module->avancement_module;
			$row[] = $module->date_fin_module;
			$row[] = $module->nom_responsable_module.' '.$module->prenom_responsable_module ;

			//add html for action
			$row[] = '<button type="button" class="btn btn-success" onclick="add_tache('."'".$module->id."'".')"><i class="glyphicon glyphicon-plus"></i> Add Tache</button>
			     <a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_mes_projets_module('."'".$module->id."'".');"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_mes_projets_module('."'".$module->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->datatable_model->count_all_where_in($table,$where),
						"recordsFiltered" => $this->datatable_model->count_filtered_where_in($table,$column,$order,$where,$where_in),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_add_tache()
	{
		$nom_tache = $this->input->post('nom_tache');
		$estimation = $this->input->post('estimation');
		$date_fin = $this->input->post('date_fin_tache');
		$id_user = $this->input->post('id_user');
		$id_module = $this->input->post('id_module');
		$data = array(
			    'id_module' => $id_module,
				'nom' => $nom_tache,
				'estimation' => $estimation,
				'date_fin' => $date_fin,
				'id_user' => $id_user,
				
			);
		$insert = $this->crud_model->save('taches',$data);
		if($insert === TRUE){
				$module = $this->crud_model->getById('view_module',$id_module);
				$data = array(
					'id_user' => $id_user,
					'texte' => 'Nouvelle Tâche! Projet :'.$module['nom_projet'].' / Module : '.$module['nom_module'].' / Tâches : '.$nom_tache.', Date fin : '.$date_fin,
				);
				$this->notification_model->setNotification($data);// notification
				echo json_encode(array("status" => TRUE));
		}else{
				echo json_encode(array("status" => FALSE));
		}
	}

}
?>