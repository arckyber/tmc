<?php

/**
 * 
 */
class Rooms extends CI_Controller
{
	
	public function index() {
		$data['title'] = 'Class room list';
		$data['rooms'] = $this->rooms_model->get_rooms();
		$this->load->view('rooms/index', $data);
	}

	public function get_room() {
		$this->form_validation->set_rules('sysid', 'ID', 'required');
		if ($this->form_validation->run() === FALSE) {
			echo "Incomplete data";
		}
		echo json_encode($this->rooms_model->get_room());
	}

	public function find_all() {
		echo json_encode($this->rooms_model->get_rooms());
	}

	public function add_room() {
		$this->form_validation->set_rules('code', 'Code', 'required');
		$this->form_validation->set_rules('descs', 'Description', 'required');
		$this->form_validation->set_rules('locations', 'Locations', 'required');
		$this->form_validation->set_rules('capacity', 'Capacity', 'required');

		if ($this->form_validation->run() === FALSE) {
			echo "Incomplete data";
			return false;
		}

		if ($this->rooms_model->add_room()) {
			echo "Add successful";
		}
		else {
			echo "Add failed";
		}
	}

	public function update_room() {
		$this->form_validation->set_rules('sysid', 'ID', 'required');
		$this->form_validation->set_rules('code', 'Code', 'required');
		$this->form_validation->set_rules('descs', 'Description', 'required');
		$this->form_validation->set_rules('locations', 'Locations', 'required');
		$this->form_validation->set_rules('capacity', 'Capacity', 'required');

		if ($this->form_validation->run() === FALSE) {
			echo "Incomplete data";
			return false;
		}

		if ($this->rooms_model->update_room()) {
			echo "Update successful";
		}
		else {
			echo "Update failed";
		}
	}

	public function block_room() {
		if ($this->rooms_model->block_room()) {
			echo "Room successfully blocked";
		}
		else {
			echo "Failed";
		}
	}

	public function delete_room() {
		if ($this->rooms_model->delete_room()) {
			echo "Room successfully deleted";
		}
		else {
			echo "Failed";
		}
	}
}

?>