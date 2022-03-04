<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller {

	public function __construct()  //생성자
	{
		parent::__construct();
		$this->load->model('Board_model');  
	}
	
	public function board_insert(){
		$title = $this->input->post('title');
		$content =  $this->input->post('content');

		$this->Board_model->board_insert($title,$content);

		header("Location: http://127.0.0.1:9005/index.php/board/list");
	}

	public function board_update(){
		$id = $this->input->post("id");
		$title = $this->input->post("title");
		$content = $this->input->post("content");

		$this->Board_model->board_update($id, $title, $content);

		header("Location: http://127.0.0.1:9005/index.php/board/view?id=".$id);
	}

	public function board_delete(){
		$id = $this->input->get("id");

		$this->Board_model->board_delete($id);

		header("Location: http://127.0.0.1:9005/index.php/board/list");
	}


	public function comment_delete(){
		$view_id = $this->input->get("id");
		$comment_id = $this->input->get("id2");

		$this->Board_model->comment_delete($view_id, $comment_id);

		header("Location: http://127.0.0.1:9005/index.php/board/view?id=".$view_id);
	}


}