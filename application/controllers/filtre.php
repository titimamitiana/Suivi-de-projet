<?php
class Filtre extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	}

	public function save_filter_project()
	{
		$data['infos_user'] = $this->session->userdata('session_user');
		$check = $this->input->post('id_projet');
		$json = json_encode($check);
		file_put_contents('Filtre/Projet/'.$data['infos_user']['id'].'.json', $json);
	    echo TRUE;
	    
	}

	public function read_filter_project()
	{
		$data['infos_user'] = $this->session->userdata('session_user');
		$json = file_get_contents('Filtre/Projet/'.$data['infos_user']['id'].'.json');
	    if( ! isset($json)){
	    	echo FALSE;
	    }
	    else
	    {
	    	echo $json;
	    }
	    
	}

	public function save_filter_module()
	{
		$data['infos_user'] = $this->session->userdata('session_user');
		$check = $this->input->post('id_module');
		$json = json_encode($check);
		file_put_contents('Filtre/Module/'.$data['infos_user']['id'].'.json', $json);
	    echo TRUE;
	    
	}

	public function read_filter_module()
	{
		$data['infos_user'] = $this->session->userdata('session_user');
		$json = file_get_contents('Filtre/Module/'.$data['infos_user']['id'].'.json');
	    if( ! isset($json)){
	    	echo FALSE;
	    }
	    else
	    {
	    	echo $json;
	    }
	    
	}

	public function save_filter_tache()
	{
		$data['infos_user'] = $this->session->userdata('session_user');
		$check = $this->input->post('id_tache');
		$json = json_encode($check);
		file_put_contents('Filtre/Tache/'.$data['infos_user']['id'].'.json', $json);
	    echo TRUE;
	    
	}

	public function read_filter_tache()
	{
		$data['infos_user'] = $this->session->userdata('session_user');
		$json = file_get_contents('Filtre/Tache/'.$data['infos_user']['id'].'.json');
	    if( ! isset($json)){
	    	echo FALSE;
	    }
	    else
	    {
	    	echo $json;
	    }
	    
	}

}