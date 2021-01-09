<?php 

/**
 * 
 */
class rooms_model extends CI_Model
{
	
	public function get_rooms() {
		$this->db->order_by('code', 'ASC');
		$this->db->where('status', 1);
		$query = $this->db->get('rooms');
		return $query->result();
	}

	public function get_room() {
		$sysid = $this->input->post('sysid');
		$this->db->where('sysid', $sysid);
		return $this->db->get('rooms')->result();
	}

	public function add_room() {
		$data = array(
			'code' => $this->input->post('code'),
			'descs' => $this->input->post('descs'),
			'locations' => $this->input->post('locations'),
			'capacity' => $this->input->post('capacity'),
			'createdby' => 12, //This is just an example
			'updatedby' => '12', //This is just an example
			'status' => 1
		);
		return $this->db->insert('rooms', $data);
	}

	public function update_room() {
		$data = array(
			'code' => $this->input->post('code'),
			'descs' => $this->input->post('descs'),
			'locations' => $this->input->post('locations'),
			'capacity' => $this->input->post('capacity'),
			'dateupdated' => date('Y-m-d H:i:s'),
			'updatedby' => 1
		);
		$sysid = $this->input->post('sysid');
		$this->db->where('sysid', $sysid);
		return $this->db->update('rooms', $data);
	}

	public function block_room() {
		$sysid = $this->input->post('sysid');
		$this->db->where('sysid', $sysid);
		return $this->db->update('rooms', ['blocked' => 1]);
	}

	public function delete_room() {
		$sysid = $this->input->post('sysid');
		$this->db->where('sysid', $sysid);
		return $this->db->update('rooms', ['status' => 0]);
	}
}

?>