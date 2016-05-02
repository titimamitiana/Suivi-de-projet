<?php
class Tache extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('crud_model');
	   $this->load->model('datatable_model');
	   $this->load->model('tache_model');
	   $this->load->model('notification_model');
	   
	}
	public function view_taches()
	{
		$page = 'tache_view';
		if ($this->session->userdata('session_user'))//si la session existe
   		{
			if ( ! file_exists(APPPATH.'/views/'.$page.'.php'))
			{
				// Whoops, we don't have a page for that!
				show_404();
			}
			$data['title'] = 'Mes Taches'; 
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

	public function ajax_list_tache($id_responsable_tache)
	{
		$table = 'view_tache';
		$column = array('id','nom_projet','nom_module','nom_tache','temps_passe','estimation','reste_a_faire','avancement_tache','depassement','date_fin_tache');
		$order = array('id' => 'desc');
		$where = array('id_responsable_tache' => $id_responsable_tache);

		$list = $this->datatable_model->get_datatables($table,$column,$order,$where);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $tache) {
			$no++;
			$row = array();
			$row[] = $tache->id;
			$row[] = $tache->nom_projet;
			$row[] = $tache->nom_module;
			$row[] = $tache->nom_tache;
			$row[] = $tache->estimation;
			$row[] = $tache->temps_passe;
			$row[] = $tache->reste_a_faire;
			$row[] = $tache->avancement_tache;
			$row[] = $tache->depassement;
			$row[] = $tache->date_fin_tache;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="'.URL.'mes_taches/info_tache/'.$tache->id.'" title="Edit" onclick=""><i class="glyphicon glyphicon-eye-open"></i> Info</a>
			<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_tache('."'".$tache->id."'".');"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
		
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

	public function info_tache($id_tache)
	{
		$page = 'tache_info';
		if ($this->session->userdata('session_user'))//si la session existe
   		{
			if ( ! file_exists(APPPATH.'/views/'.$page.'.php'))
			{
				// Whoops, we don't have a page for that!
				
			}
			$data['title'] = 'Mes Taches Info'; 
			$data['infos_user'] = $this->session->userdata('session_user');
			$data['tache'] = $this->crud_model->getById('view_tache',$id_tache);
			if( isset($data['tache']['id']))
				$data['project'] = $this->crud_model->getById('projet',$data['tache']['id_projet']);
			if( isset($data['tache']['id']) && $data['project']['id_user'] == $data['tache']['id_responsable_projet']){
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

	public function ajax_list_tache_info($id_tache)
	{
		$table = 'calendrier_tache';
		$column = array('date','duree');
		$order = array('date' => 'desc');
		$where = array('id_tache' => $id_tache);

		$list = $this->datatable_model->get_datatables($table,$column,$order,$where);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $tache_info) {
			$no++;
			$row = array();
			$row[] = $tache_info->date;
			$row[] = $tache_info->duree;
		
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

	public function ajax_update_avancement_tache()
	{
		$id_tache = $this->input->post('id_tache');
		$temps_passe = $this->input->post('temps_passe');
		$temps_passe_initial = $this->input->post('temps_passe_initial');
		$reste_a_faire = $this->input->post('reste_a_faire');
		$data_calendrier = array(
				'date' => date('Y-m-d'),
				'duree' => $temps_passe,
				'id_tache' => $id_tache,
			);
		$result = $this->crud_model->save('calendrier_tache',$data_calendrier);
		if($result === TRUE){
			$data_tache = array(
				'reste_a_faire' => $reste_a_faire,
				'temps_passe' => $temps_passe+$temps_passe_initial,
			);
		
			$this->crud_model->update('taches', $data_tache,array('id' => $id_tache));

			if($reste_a_faire == 0){// si reste à faire 0 alors notification
				$module =  $this->tache_model->getIdUserModuleByIdTache($id_tache);
				$tache =  $this->crud_model->getById('view_tache',$id_tache);
				$data = array(
					'id_user' => $module['id_user'],
					'texte' => 'Tache terminé! Projet :'.$tache['nom_projet'].' / Module : '.$tache['nom_module'].' / Tache :'.$tache['nom_tache'],
				);
				$this->notification_model->setNotification($data);// notification
			}
			echo json_encode(array("status" => TRUE));
		}else{
			echo json_encode(array("status" => FALSE,"error" => $result));
		}
	}



	public function ajax_edit_tache($id)
	{
		$data = $this->crud_model->getById('view_tache',$id);
		echo json_encode($data);
	}

	public function ajax_add_tache($id_module)
	{
		$nom_tache = $this->input->post('nom_tache');
		$estimation = $this->input->post('estimation');
		$date_fin = $this->input->post('date_fin_tache');
		$id_user = $this->input->post('id_user');
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

	public function ajax_update_tache()
	{
		$id_tache = $this->input->post('id_tache');
		$nom_tache = $this->input->post('nom_tache');
		$estimation = $this->input->post('estimation');
		$date_fin = $this->input->post('date_fin_tache');
		$id_user = $this->input->post('id_user');
		$id_user_initial = $this->input->post('id_user_initial');
		$data = array(
				'nom' => $nom_tache,
				'estimation' => $estimation,
				'date_fin' => $date_fin,
				'id_user' => $id_user,
			);
		$update = $this->crud_model->update('taches', $data,array('id' => $id_tache));
		if($update === TRUE){
			if($id_user != $id_user_initial){
				$tache = $this->crud_model->getById('view_tache',$id_tache);
				$data_nouveau_tache = array(
					'id_user' => $id_user,
					'texte' => 'Nouvelle Tâche! Projet :'.$tache['nom_projet'].' / Module : '.$tache['nom_module'].' / Tâches : '.$nom_tache.', Date fin : '.$date_fin,
				);
				$this->notification_model->setNotification($data_nouveau_tache);// notification nouveau tache
				$data_tache_annule = array(
					'id_user' => $id_user_initial,
					'texte' => 'Tâche Annulée! Projet :'.$tache['nom_projet'].' / Module : '.$tache['nom_module'].' / Tâches : '.$nom_tache,
				);
				$this->notification_model->setNotification($data_tache_annule);// notification nouveau annulé
			}
			echo json_encode(array("status" => TRUE));
		}else
		{
			echo json_encode(array("status" => FALSE));
		}
		
	}

	public function ajax_delete_tache($id)
	{
		$tache = $this->crud_model->getById('view_tache',$id);
		$data_tache_annule = array(
				'id_user' => $tache['id_responsable_tache'],
				'texte' => 'Tâche Annulée! Projet :'.$tache['nom_projet'].' / Module : '.$tache['nom_module'].' / Tâches : '.$tache['nom_tache'],
				'statut_notification' => 1,
		);
		$this->notification_model->setNotification($data_tache_annule);// notification tache annule
		$this->crud_model->delete('taches',$id);
		echo json_encode(array("status" => TRUE));
	}

	

}