<?php
class Tache_model extends CI_Model {

	var $table_tache_info = 'calendrier_tache';
	var $column_tache_info = array('date','duree');
	var $order_tache_info = array('date' => 'desc');

	public function __construct()
	{
		$this->load->database();
	}

	public function getIdUserModuleByIdTache($id_tache)
    {
        $req="SELECT module.id_user FROM taches left join module on taches.id_module=module.id WHERE taches.id=".$id_tache;
        $query = $this->db->query($req);

        return $query->row_array();
    }
	
}
?>
