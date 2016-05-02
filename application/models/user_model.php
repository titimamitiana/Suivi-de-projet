<?php
Class User_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	function login($login, $password)
	{
	   $this->db-> select('id, nom, prenom, fonction, statut, login, password');
	   $this->db-> from('user');
	   $this->db-> where('login', $login);
	   $this->db-> where('password', MD5($password));
	   $this->db-> limit(1);
	 
	   $query = $this->db->get();
	 
	   if ($query->num_rows() == 1)
	   {
		 return $query->row();
	   }
	   else
	   {
		 return FALSE;
	   }
	}
}
?>