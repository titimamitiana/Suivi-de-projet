<?php
class Profil extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('profil_model');
	}

	public function testDroit()
	{
		$table = $this->input->post('table');
		$id_user = $this->input->post('id_user');
		$id = $this->input->post('id');
		$data = $this->profil_model->VerifierDroit($table, $id_user,$id);
		if($data === TRUE){
			echo TRUE;
		}else{
			echo FALSE;
		}
	}

	public function testDroitTache()
	{
		$id_user = $this->input->post('id_user');
		$id = $this->input->post('id');
		$data = $this->profil_model->VerifierDroitTache($id_user,$id);
		if($data === TRUE){
			echo TRUE;
		}else{
			echo FALSE;
		}
	}

	public function testDroitModule()
	{
		$id_user = $this->input->post('id_user');
		$id = $this->input->post('id');
		$data = $this->profil_model->VerifierDroitModule($id_user,$id);
		if($data === TRUE){
			echo TRUE;
		}else{
			echo FALSE;
		}
	}

	public function isSuperManager()
	{
		$id_user = $this->input->post('id_user');
		$data = $this->profil_model->isSuperManager($id_user);
		if($data === TRUE){
			echo TRUE;
		}else{
			echo FALSE;
		}
	}

}
?>