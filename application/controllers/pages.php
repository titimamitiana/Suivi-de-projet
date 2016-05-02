<?php
class Pages extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	   // Load session library
		$this->load->library('session');
	}
	public function home()
	{
		$page = 'home';
		if($this->session->userdata('session_user'))//si la session existe
   		{
			if ( ! file_exists(APPPATH.'/views/'.$page.'.php'))
			{
				// Whoops, we don't have a page for that!
				show_404();
			}
			$data['title'] = ucfirst($page); // Capitalize the first letter
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
	
}
?>