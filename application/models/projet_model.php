<?php
class Projet_model extends CI_Model {

	
	var $table_mes_projets = 'view_projet';
	var $column_mes_projets = array('id_projet','nom_projet','avancement_projet','date_debut_projet','date_fin_projet');
	var $order_mes_projets = array('id_projet' => 'desc');

	var $table_mes_projets_module = 'view_module';
	var $column_mes_projets_module = array('id_module','nom_module','avancement_module','date_fin_module','nom_responsable_module');
	var $order_mes_projets_module = array('id_module' => 'desc');

	var $table_mes_projets_tache = 'view_tache';
	var $column_mes_projets_tache = array('id_tache','nom_tache','temps_passe','estimation','reste_a_faire','avancement_tache','depassement','date_fin_tache','nom_responsable_tache');
	var $order_mes_projets_tache = array('id_tache' => 'desc');

	public function __construct()
	{
		$this->load->database();
	}
	/**** Mes projets *****/

	private function _get_datatables_query_mes_projets($id_responsable_projet)
	{
		$this->db->select('id_projet,nom_projet,avancement_projet,date_debut_projet,date_fin_projet');
		$this->db->from($this->table_mes_projets);
		$this->db->where('id_responsable_projet',$id_responsable_projet);  
        
        if($_POST['search']['value']){
        	$this->db->like('nom_projet', $_POST['search']['value']);
			$this->db->or_like('id_projet', $_POST['search']['value']); 
			$this->db->or_like('date_debut_projet', $_POST['search']['value']); 
			$this->db->or_like('date_fin_projet', $_POST['search']['value']); 
        }
		$i = 0;
	
		foreach ($this->column_mes_projets as $item) 
		{
			if($_POST['search']['value'])
				($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
			$column_mes_projets[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column_mes_projets[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order_mes_projets))
		{
			$order_mes_projets = $this->order_mes_projets;
			$this->db->order_by(key($order_mes_projets), $order_mes_projets[key($order_mes_projets)]);
		}
	}

	function get_datatables_mes_projets($id_responsable_projet)
	{
		$this->_get_datatables_query_mes_projets($id_responsable_projet);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_mes_projets($id_responsable_projet)
	{
		$this->_get_datatables_query_mes_projets($id_responsable_projet);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_mes_projets($id_responsable_projet)
	{
		$this->db->select('*');
        $this->db->from($this->table_mes_projets); 
        $this->db->where('id_responsable_projet',$id_responsable_projet);   
		return $this->db->count_all_results();
	}

	public function get_by_id_mes_projets($id)
	{
		$this->db->from('projet');
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save_mes_projets($data)
	{
		$this->db->insert('projet', $data);
		return $this->db->insert_id();
	}

	public function update_mes_projets($where, $data)
	{
		$this->db->update('projet', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id_mes_projets($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('projet');
	}

	/**** Fin mes projets ***/

	/****  modules ***/
	private function _get_datatables_query_mes_projets_module($id_projet)
	{
		$this->db->select('id_module,nom_module,avancement_module,date_fin_module,id_responsable_module,nom_responsable_module,prenom_responsable_module,id_projet');
		$this->db->from($this->table_mes_projets_module);
		$this->db->where('id_projet',$id_projet);  
        
        if($_POST['search']['value']){
        	$this->db->like('id_module', $_POST['search']['value']);
			$this->db->or_like('nom_module', $_POST['search']['value']); 
			$this->db->or_like('avancement_module', $_POST['search']['value']); 
			$this->db->or_like('date_fin_module', $_POST['search']['value']); 
			$this->db->or_like('CONCAT(nom_responsable_module," ",prenom_responsable_module)', $_POST['search']['value']); 
        }
		$i = 0;
	
		foreach ($this->column_mes_projets_module as $item) 
		{
			$column_mes_projets_module[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column_mes_projets_module[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order_mes_projets_module))
		{
			$order_mes_projets_module = $this->order_mes_projets_module;
			$this->db->order_by(key($order_mes_projets_module), $order_mes_projets_module[key($order_mes_projets_module)]);
		}
	}

	function get_datatables_mes_projets_module($id_projet)
	{
		$this->_get_datatables_query_mes_projets_module($id_projet);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_mes_projets_module($id_projet)
	{
		$this->_get_datatables_query_mes_projets_module($id_projet);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_mes_projets_module($id_projet)
	{
		$this->db->select('*');
        $this->db->from($this->table_mes_projets_module); 
        $this->db->where('id_projet',$id_projet);   
		return $this->db->count_all_results();
	}

	public function get_by_id_mes_projets_module($id_module)
	{
		$this->db->from('module');
		$this->db->where('id',$id_module);
		$query = $this->db->get();

		return $query->row();
	}

	public function save_mes_projets_module($data)
	{
		$this->db->insert('module', $data);
		return $this->db->insert_id();
	}

	public function update_mes_projets_module($where, $data)
	{
		$this->db->update('module', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id_mes_projets_module($id_module)
	{
		$this->db->where('id', $id_module);
		$this->db->delete('module');
	}
	/**** Fin modules ***/

	/**** taches ***/
	private function _get_datatables_query_mes_projets_tache($id_module)
	{

		$this->db->select('id_tache,nom_tache,estimation,temps_passe,reste_a_faire,avancement_tache,depassement,date_fin_tache,id_responsable_tache,nom_responsable_tache,
			prenom_responsable_tache,id_module');
		$this->db->from($this->table_mes_projets_tache);
		$this->db->where('id_module',$id_module);  
        
        if($_POST['search']['value']){
        	$this->db->like('id_tache', $_POST['search']['value']);
			$this->db->or_like('nom_tache', $_POST['search']['value']); 
			$this->db->or_like('estimation', $_POST['search']['value']); 
			$this->db->or_like('temps_passe', $_POST['search']['value']); 
			$this->db->or_like('reste_a_faire', $_POST['search']['value']); 
			$this->db->or_like('avancement_tache', $_POST['search']['value']); 
			$this->db->or_like('depassement', $_POST['search']['value']); 
			$this->db->or_like('date_fin_tache', $_POST['search']['value']); 
			$this->db->or_like('CONCAT(nom_responsable_tache," ",prenom_responsable_tache)', $_POST['search']['value']); 
        }
		$i = 0;
	
		foreach ($this->column_mes_projets_tache as $item) 
		{
			$column_mes_projets_tache[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column_mes_projets_tache[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order_mes_projets_tache))
		{
			$order_mes_projets_tache = $this->order_mes_projets_tache;
			$this->db->order_by(key($order_mes_projets_tache), $order_mes_projets_tache[key($order_mes_projets_tache)]);
		}
	}

	function get_datatables_mes_projets_tache($id_module)
	{
		$this->_get_datatables_query_mes_projets_tache($id_module);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_mes_projets_tache($id_module)
	{
		$this->_get_datatables_query_mes_projets_tache($id_module);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_mes_projets_tache($id_module)
	{
		$this->db->select('*');
        $this->db->from($this->table_mes_projets_tache); 
        $this->db->where('id_module',$id_module);   
		return $this->db->count_all_results();
	}

	public function get_by_id_mes_projets_tache($id_tache)
	{
		$this->db->from('taches');
		$this->db->where('id',$id_tache);
		$query = $this->db->get();

		return $query->row();
	}

	public function save_mes_projets_tache($data)
	{
		$this->db->insert('taches', $data);
		return $this->db->insert_id();
	}

	public function update_mes_projets_tache($where, $data)
	{
		$this->db->update('taches', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id_mes_projets_tache($id_tache)
	{
		$this->db->where('id', $id_tache);
		$this->db->delete('taches');
	}
	/**** Fin taches ***/

	public function getProjetById($id_projet)
	{
		$this->db->select('*');
        $this->db->from('projet'); 
	    $this-> db->where('id', $id_projet);
			
        $query = $this->db->get(); 
        return $query->row_array();
	}
	public function getAllUser()
	{
		$this->db->select('*');
        $this->db->from('user'); 
			
        $query = $this->db->get(); 
        return $query->result_array();
	}
	public function getModuleById($id_module)
	{
		$this->db->select('*');
        $this->db->from('module'); 
	    $this-> db->where('id', $id_module);
			
        $query = $this->db->get(); 
        return $query->row_array();
	}
	public function getTacheByIdModule($id_module)
	{
		$this->db->select('*');
        $this->db->from('view_tache'); 
	    $this-> db->where('id_module', $id_module);
			
        $query = $this->db->get(); 
        return $query->result_array();
	}
	
	
}
?>