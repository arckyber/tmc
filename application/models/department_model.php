<?php 

/**
 * 
 */
class department_model extends CI_Model
{

	public function get_department() {
		$sysid = $this->input->post('sysid');
		$this->db->where('sysid', $sysid);
		$this->db->where('status', 1);
		return $this->db->get('departments_main')->result();
	}
	
	public function get_departments() {
		$this->db->order_by('code', 'ASC');
		$this->db->where('status', 1);
		$query = $this->db->get('departments_main');
		return $query->result();
	}

	public function add() {
		$data = array(
			'code' => $this->input->post('code'),
			'descriptions' => $this->input->post('descriptions'),
			'createdby' => 12, //This is just an example
			'updatedby' => '12', //This is just an example
			'status' => 1
		);
		return $this->db->insert('departments_main', $data);
	}

	public function update() {
		$data = array(
			'code' => $this->input->post('code'),
			'descriptions' => $this->input->post('descriptions'),
			'dateupdated' => date('Y-m-d H:i:s'),
			'updatedby' => 1
		);
		$sysid = $this->input->post('sysid');
		$this->db->where('sysid', $sysid);
		return $this->db->update('departments_main', $data);
	}

	public function delete() {
		$sysid = $this->input->post('sysid');
		$this->db->where('sysid', $sysid);
		return $this->db->update('departments_main', ['status' => 0]);
	}
}

?>