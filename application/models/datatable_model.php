<?php
class Datatable_model extends CI_Model {
	public function __construct()
	{
		$this->load->database();
	}

	private function _get_datatables_query($table,$column,$order,$where)
	{
		
		$this->db->from($table);

		if( ! empty( $where ) )
		{
			$this->db->where($where);
		}

		$i = 0;
		$requete = '';
		foreach ($column as $item) 
		{
			if($_POST['search']['value'])
				$requete = ($i===0) ? $requete.$item." LIKE '%".$_POST['search']['value']."%'" : $requete." OR ".$item." LIKE '%".$_POST['search']['value']."%'";
			$column[$i] = $item;
			$i++;
		}
		if($_POST['search']['value'])
			$this->db->where("(".$requete.")");

		if(isset($_POST['order']))
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($order))
		{
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($table,$column,$order,$where)
	{
		$this->_get_datatables_query($table,$column,$order,$where);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($table,$column,$order,$where)
	{
		$this->_get_datatables_query($table,$column,$order,$where);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($table,$where)
	{
		$this->db->from($table);
		if( ! empty( $where ) )
		{
			$this->db->where($where);
		}
		return $this->db->count_all_results();
	}

	/****** datatable where in condition *******/
	private function _get_datatables_query_where_in($table,$column,$order,$where,$where_in)
	{
		
		$this->db->from($table);

		if( ! empty( $where ) )
		{
			$this->db->where($where);
		}
		if( ! empty( $where_in ) )
		{
			$this->db->where_in('id', $where_in);
		}
		

		$i = 0;
		$requete = '';
		foreach ($column as $item) 
		{
			if($_POST['search']['value'])
				$requete = ($i===0) ? $requete.$item." LIKE '%".$_POST['search']['value']."%'" : $requete." OR ".$item." LIKE '%".$_POST['search']['value']."%'";
			$column[$i] = $item;
			$i++;
		}
		if($_POST['search']['value'])
			$this->db->where("(".$requete.")");

		if(isset($_POST['order']))
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($order))
		{
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_where_in($table,$column,$order,$where,$where_in)
	{
		$this->_get_datatables_query_where_in($table,$column,$order,$where,$where_in);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_where_in($table,$column,$order,$where,$where_in)
	{
		$this->_get_datatables_query_where_in($table,$column,$order,$where,$where_in);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_where_in($table,$where)
	{
		$this->db->from($table);
		if( ! empty( $where ) )
		{
			$this->db->where($where);
		}
		return $this->db->count_all_results();
	}
}
?>