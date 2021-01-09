<?php

class Departments extends CI_Controller
{
	
	public function index() {
		$data['title'] = 'Deparment list';
		$this->load->view('templates/header');
		$this->load->view('templates/nav');
		$this->load->view('departments/index', $data);
		$this->load->view('templates/footer');
	}

	public function get_department() {
		echo json_encode($this->department_model->get_department());
	}

	public function get_departments() {
		echo json_encode($this->department_model->get_departments());
	}

	public function add() {
		$this->form_validation->set_rules('code', 'Code', 'required');
		$this->form_validation->set_rules('descriptions', 'Description', 'required');

		if ($this->form_validation->run() === FALSE) {
			echo "Incomplete data";
			return false;
		}

		if ($this->department_model->add()) {
			echo "Add successful";
		}
		else {
			echo "Add failed";
		}
	}

	public function update() {
		$this->form_validation->set_rules('sysid', 'ID', 'required');
		$this->form_validation->set_rules('code', 'Code', 'required');
		$this->form_validation->set_rules('descriptions', 'Description', 'required');

		if ($this->form_validation->run() === FALSE) {
			echo "Incomplete data";
			return false;
		}

		if ($this->department_model->update()) {
			echo "Update successful";
		}
		else {
			echo "Update failed";
		}
	}

	public function delete() {
		if ($this->department_model->delete()) {
			echo "Room successfully deleted";
		}
		else {
			echo "Failed";
		}
	}

}

?>