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

		$search = $this->input->get('search');
		$now_page =  $this->uri->segment(3); 
		//전체글 개수 가져오기
		$result_count = $this->Board_model->list_total($search); 
		//리스트 값 가져오기
		$result_list = $this->Board_model->list_select($now_page, $search);

		// pagenation 시작
		$this->load->library('pagination'); 
		$config['base_url'] = 'http://127.0.0.1:9005/index.php/board/list';
		$config['total_rows'] = $result_count->cnt;
		$config['per_page'] = 10; 
		$config['num_links'] = 3;
		$config['full_tag_open'] = '<p>'; 
		$config['full_tag_close'] = '</p>';
		$config['first_link'] = '처음으로';
		$config['last_link'] = '끝으로';
		$config['reuse_query_string'] = true;
		$this->pagination->initialize($config);
		//pagenation 끝
		

		$data['page_nation'] =  $this->pagination->create_links();
		$data['list'] = $result_list; 
		$data['search'] = $search;

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