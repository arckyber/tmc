<?php

/**
 * 
 */
class Home extends CI_Controller
{
	
	public function index() {
		$data['title'] = "Home page";
		$this->load->view("templates/header");
		$this->load->view("templates/nav");
		$this->load->view("home/index", $data);
	}
}