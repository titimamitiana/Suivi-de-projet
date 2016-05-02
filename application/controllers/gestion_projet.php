<?php
class Gestion_projet extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('gestion_projet_model');
	    $this->load->model('crud_model');
	    $this->load->model('datatable_model');
	   $this->load->model('user_model');
	   $this->load->model('notification_model');
	}
	public function view_projets()
	{
		$page = 'gestion_projet_view';
		if ($this->session->userdata('session_user'))//si la session existe
   		{
			if ( ! file_exists(APPPATH.'/views/'.$page.'.php'))
			{
				// Whoops, we don't have a page for that!
				show_404();
			}
			$data['title'] = 'Liste Projets'; 
			$data['list_user'] = $this->crud_model->getAll('user');
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

	public function ajax_list_projet()
	{
		$table = 'view_projet';
		$column = array('id','id','nom_projet','avancement_projet','date_debut_projet','date_fin_projet','nom_responsable_projet');
		$order = array('id' => 'desc');
		$where = array();

		$list = $this->datatable_model->get_datatables($table,$column,$order,$where);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $projet) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" id="select" name="id_projet[]" value="'.$projet->id.'">';
			$row[] = $projet->id;
			$row[] = $projet->nom_projet;
			$row[] = $projet->avancement_projet;
			$row[] = $projet->date_debut_projet;
			$row[] = $projet->date_fin_projet;
			$row[] = $projet->nom_responsable_projet.' '.$projet->prenom_responsable_projet;

			//add html for action
			$row[7] = '<button type="button" class="btn btn-success" onclick="add_module('."'".$projet->id."'".')"><i class="glyphicon glyphicon-plus"></i> Add Module</button>
			<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_projet('."'".$projet->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_projet('."'".$projet->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
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

	public function ajax_list_projet_my_filter()
	{
		$data['infos_user'] = $this->session->userdata('session_user');
		$json = file_get_contents('Filtre/Projet/'.$data['infos_user']['id'].'.json');
		$str = str_replace(array('"','"','[',']'),"",$json);
		$arr = explode(',', $str);

		$table = 'view_projet';
		$column = array('id','id','nom_projet','avancement_projet','date_debut_projet','date_fin_projet','nom_responsable_projet');
		$order = array('id' => 'desc');
		$where = array();
		$where_in = $arr;

		$list = $this->datatable_model->get_datatables_where_in($table,$column,$order,$where,$where_in);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $projet) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="id_projet[]" value="'.$projet->id.'">';
			$row[] = $projet->id;
			$row[] = $projet->nom_projet;
			$row[] = $projet->avancement_projet;
			$row[] = $projet->date_debut_projet;
			$row[] = $projet->date_fin_projet;
			$row[] = $projet->nom_responsable_projet.' '.$projet->prenom_responsable_projet;

			//add html for action
			$row[7] = '<button type="button" class="btn btn-success" onclick="add_module('."'".$projet->id."'".')"><i class="glyphicon glyphicon-plus"></i> Add Module</button>
			<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_projet('."'".$projet->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_projet('."'".$projet->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
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


	public function ajax_add_module()
	{
		$nom_module = $this->input->post('nom_module');
		$id_user = $this->input->post('id_user');
		$id_projet = $this->input->post('id_projet');
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
	
	
}
?>