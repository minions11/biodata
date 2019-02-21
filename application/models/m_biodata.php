<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_biodata extends CI_Model {

public function input_data($data,$table)
	{
		$this->db->insert($table,$data);
	}	
public function update_data($where,$data,$table)
{
	$this->db->where($where);
	$this->db->update($table,$data);
}
public function hapus_data($where,$table)
{
	$this->db->where($where);
	$this->db->delete($table);
}
}

/* End of file m_biodata.php */
/* Location: ./application/models/m_biodata.php */