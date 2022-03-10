<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends CI_Controller {

	public function __construct()  //생성자
	{
		parent::__construct();
		$this->load->model('Board_model');  
		$this->load->library('session');

		if($this->session->userdata('email') == "")
		{
			header("Location: /index.php/member/login"); 
		}
		
	}

	public function change_board()
	{
		$type = $this->input->get('type');
		$this->session->set_userdata("type",$type);
 
		header("Location: /index.php/board/list"); 
	}

	public function index()
	{
		$this->list();
	} 

	public function list(){

		//$search = $_GET['search'];
		$search = $this->input->get('search');
		$data['email'] = $this->session->userdata('email');
		
		$board_type = $this->session->userdata('type');

		$now_page =  $this->uri->segment(3); 
		//전체글 개수 가져오기
		$result_count = $this->Board_model->list_total($search,$board_type); 
		//리스트 값 가져오기
		$result_list = $this->Board_model->list_select($now_page,$search,$board_type);

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

		$this->load->view('board/nav',$data); 
		$this->load->view('board/list',$data); 
	}

	public function view(){
		
		$id =  $this->input->get('id');
		$data['email'] = $this->session->userdata('email');

		$result = $this->Board_model->view_select($id);
		$data['result'] = $result;
		$data['member_id'] = $this->session->userdata('_id');
		$data['email'] = $this->session->userdata('email');

		$this->load->view('board/nav',$data); 
		$this->load->view('board/view',$data);
		$this->comment_list($id);
	}

	public function input(){
		$data['email'] = $this->session->userdata('email');

		$this->load->view('board/nav' ,$data); 
		$this->load->view('board/input');
	}

	public function update(){
		$id = $this->input->get('id');
		$data['email'] = $this->session->userdata('email');

		$result = $this->Board_model->view_select($id);
		$data['result'] = $result;
		
		$this->load->view('board/nav',$data); 
		$this->load->view('board/update',$data);
	}

	private function comment_list($board_id)
	{ 
		$data['result'] = $this->Board_model->comment_list($board_id);
		$data['board_id'] = $board_id;
		$data['member_id'] = $this->session->userdata('_id');
		$this->load->view("comment/list",$data);
	}
}
