<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends CI_Controller {

	public function __construct()  //생성자
	{
		parent::__construct();
		$this->load->model('Board_model');  
	}

	public function index()
	{
		$this->list();
	} 

	public function list(){
		$result = $this->Board_model->list_select();

		$data['list'] = $result; 
		$this->load->view('board/list',$data);
	}

	public function view(){
		$this->load->view('board/view');
	}

	public function input(){
		$this->load->view('board/input');
	}

	public function update(){
		$this->load->view('board/update');
	}
}