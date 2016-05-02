<?php
Class Profil_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	function VerifierDroit($table, $id_user,$id)
	{
	   $req = "select * from ".$table." join user on user.id = ".$table.".id_user WHERE ((".$table.".id = ".$id." and user.id=".$id_user.") or (user.id=".$id_user." and user.statut = 1));";
	   
        $query = $this->db->query($req);
	 
	   if ($query->num_rows() > 0)
	   {
		 return TRUE;
	   }
	   else
	   {
		 return FALSE;
	   }
	}

	function VerifierDroitTache( $id_user,$id)
	{
	   $req = "select * from view_tache join user on user.id = view_tache.id_responsable_tache WHERE ((view_tache.id = ".$id." and (view_tache.id_responsable_projet=".$id_user." or  view_tache.id_responsable_module=".$id_user."))  or (user.id=".$id_user." and user.statut = 1));";
	   
        $query = $this->db->query($req);
	 
	   if ($query->num_rows() > 0)
	   {
		 return TRUE;
	   }
	   else
	   {
		 return FALSE;
	   }
	}

	function VerifierDroitModule( $id_user,$id)
	{
	   $req = "select * from view_module join user on user.id = view_module.id_responsable_module WHERE ((view_module.id = ".$id." and (view_module.id_responsable_projet=".$id_user." ))  or (user.id=".$id_user." and user.statut = 1));";
	   
        $query = $this->db->query($req);
	 
	   if ($query->num_rows() > 0)
	   {
		 return TRUE;
	   }
	   else
	   {
		 return FALSE;
	   }
	}

	function isSuperManager($id_user)
	{
	   $this->db-> select('*');
	   $this->db-> from('user');
	   $this->db-> where('id', $id_user);
	   $this->db-> where('statut', 1);
	   $this->db-> limit(1);
	   $query = $this->db->get();
	 
	   if ($query->num_rows() == 1)
	   {
		 return TRUE;
	   }
	   else
	   {
		 return FALSE;
	   }
	}
}
?>