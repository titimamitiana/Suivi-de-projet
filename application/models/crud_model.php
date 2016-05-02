<?php
class Crud_model extends CI_Model {
	public function __construct()
	{
		$this->load->database();
	}

	public function getAll($table){
        $this->db->from($table);
        $query = $this->db->get();

        return $query->result_array();
    }

	public function getById($table,$id)
	{
		$this->db->from($table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row_array();
	}

	public function getBy($table,$array)
	{
		$this->db->from($table);
		$this->db->where($array);
		$query = $this->db->get();

		return $query->result_array();
	}

	public function save($table,$data)
	{
		$query = $this->db->insert($table, $data);
		if($query)
		{
			return TRUE;
		}
		else
		{
			return $this->db->_error_message();
		}
	}

	public function update($table,$data,$where)
	{
		$query = $this->db->update($table, $data, $where);
		if($query)
		{
			return TRUE;
		}
		else
		{
			return $this->db->_error_message();
		}
	}

	public function delete($table,$id)
	{
		$this->db->where('id', $id);
		$query = $this->db->delete($table);
		if($query)
		{
			return TRUE;
		}
		else
		{
			return $this->db->_error_message();
		}
	}

	 
}
?>