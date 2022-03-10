<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller {

	public function __construct()  //생성자
	{
		parent::__construct();
		$this->load->model('Board_model');  
		$this->load->library('session');
	}
	
	public function board_insert(){
		$title = $this->input->post('title');
		$content =  $this->input->post('content');
		$member_id = $this->session->userdata('_id');
		$board_type = $this->session->userdata('type');

		$this->Board_model->board_insert($title,$content,$member_id,$board_type);

		header("Location: http://127.0.0.1:9005/index.php/board/list");
	}

	public function board_update()
	{
		$id =  $this->input->post("id"); 
		$title =  $this->input->post("title"); 
		$content = $this->input->post("content");

		$this->Board_model->board_update($title,$content,$id);
		
		header("Location: /index.php/board/view?id=".$id);
	}


	public function comment_insert()
	{
		$content =  $this->input->post("content"); 
		$board_id =  $this->input->post("board_id");  
		$member_id = $this->session->userdata('_id');

		$this->Board_model->comment_insert($content,$board_id,$member_id);
		
		header("Location: /index.php/board/view?id=".$board_id);
	}

	public function board_delete()
	{ 
		$board_id =  $this->input->get("id");  

		$this->Board_model->board_delete($board_id);
		
		header("Location: /index.php/board/list");
	}

	public function comment_delete()
	{
		$comment_id =  $this->input->get("comment_id"); 
		$board_id =  $this->input->get("board_id");  

		$this->Board_model->comment_delete($comment_id);
		
		header("Location: /index.php/board/view?id=".$board_id);
	}
}
