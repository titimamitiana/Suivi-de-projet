<?php
class Gestion_tache extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('gestion_projet_model');
	   $this->load->model('crud_model');
	   $this->load->model('datatable_model');
	   $this->load->model('user_model');
	   $this->load->model('notification_model');
	   $this->load->model('tache_model');
	}

	public function view_taches()
	{
		$page = 'gestion_projet_tache_view';
		if ($this->session->userdata('session_user'))//si la session existe
   		{
			if ( ! file_exists(APPPATH.'/views/'.$page.'.php'))
			{
				// Whoops, we don't have a page for that!
				show_404();
			}
			$data['title'] = 'Taches'; 
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
	
	public function ajax_list_tache()
	{
		$table = 'view_tache';
		$column = array('id','id','nom_projet','nom_tache','temps_passe','estimation','reste_a_faire','avancement_tache','depassement','date_fin_tache','nom_responsable_tache');
		$order = array('id' => 'desc');
		$where = array();

		$list = $this->datatable_model->get_datatables($table,$column,$order,$where);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $tache) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="id_tache[]" value="'.$tache->id.'">';
			$row[] = $tache->id;
			$row[] = $tache->nom_projet.' / '.$tache->nom_module;
			$row[] = $tache->nom_tache;
			$row[] = $tache->estimation;
			$row[] = $tache->temps_passe;
			$row[] = $tache->reste_a_faire;
			$row[] = $tache->avancement_tache;
			$row[] = $tache->depassement;
			$row[] = $tache->date_fin_tache;
			$row[] = $tache->nom_responsable_tache.' '.$tache->prenom_responsable_tache ;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="'.URL.'mes_taches/info_tache/'.$tache->id.'" title="Edit" onclick=""><i class="glyphicon glyphicon-eye-open"></i> Info</a>
			<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_avancement('."'".$tache->id."'".');"><i class="glyphicon glyphicon-pencil"></i> Avancement</a>
			<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_mes_projets_tache('."'".$tache->id."'".');"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
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

	public function ajax_list_tache_my_filter()
	{
		$data['infos_user'] = $this->session->userdata('session_user');
		$json = file_get_contents('Filtre/Tache/'.$data['infos_user']['id'].'.json');
		$str = str_replace(array('"','"','[',']'),"",$json);
		$arr = explode(',', $str);

		$table = 'view_tache';
		$column = array('id','id','nom_projet','nom_tache','temps_passe','estimation','reste_a_faire','avancement_tache','depassement','date_fin_tache','nom_responsable_tache');
		$order = array('id' => 'desc');
		$where = array();
		$where_in = $arr;

		$list = $this->datatable_model->get_datatables_where_in($table,$column,$order,$where,$where_in);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $tache) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="id_tache[]" value="'.$tache->id.'">';
			$row[] = $tache->id;
			$row[] = $tache->nom_projet.' / '.$tache->nom_module;
			$row[] = $tache->nom_tache;
			$row[] = $tache->estimation;
			$row[] = $tache->temps_passe;
			$row[] = $tache->reste_a_faire;
			$row[] = $tache->avancement_tache;
			$row[] = $tache->depassement;
			$row[] = $tache->date_fin_tache;
			$row[] = $tache->nom_responsable_tache.' '.$tache->prenom_responsable_tache ;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="'.URL.'mes_taches/info_tache/'.$tache->id.'" title="Edit" onclick=""><i class="glyphicon glyphicon-eye-open"></i> Info</a>
			<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_avancement('."'".$tache->id."'".');"><i class="glyphicon glyphicon-pencil"></i> Avancement</a>
			<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_mes_projets_tache('."'".$tache->id."'".');"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_mes_projets_tache('."'".$tache->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
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
	
}
?>