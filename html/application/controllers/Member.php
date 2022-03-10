<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

	public function __construct()  //생성자
	{
		parent::__construct();
		$this->load->model('Board_model');  
		$this->load->library('session');
	}

	public function index()
	{
		echo "회원 프로그램";
	} 

	public function input(){
 		$data['msg'] = $this->input->get("msg");
		$this->load->view('member/input',$data);
	}

	public function insert(){
		$email =  $this->input->post("email"); 
		$password = $this->input->post("password");
		$password = md5($password);
 
		$result = $this->Board_model->member_insert($email,$password);

		if($result == true)
		{
			header("Location: /index.php/member/login");
		}
		else {
			header("Location: /index.php/member/input?msg=있는 이메일입 니다");
		}
	}

	public function login(){
		
		$this->session->sess_destroy(); // 세션 삭제
		$this->load->view("member/login");
	}

	public function update(){
		$data['msg'] = $this->input->get("msg");
		$data["email"] = $this->session->userdata('email');
		$this->load->view('member/update',$data);
	}

	public function session()
	{
		$email = $this->input->post("email"); 
		$password = $this->input->post("password");
		$password = md5($password);

		$result = $this->Board_model->login_select($email,$password);

		if(isset($result->_id))
		{
			$newdata = array( 
				'email'     => $email,
				'_id' 		=> $result->_id
			);

			$this->session->set_userdata($newdata);

			header("Location: /index.php/board/list");
		}
		else
		{ 
			header("Location: /index.php/member/login");
		}
	}

	public function modify()
	{
		$old_email = $this->session->userdata('email');
		$old_password =  md5($this->input->post("password"));
		
		$new_email = $this->input->post("email"); 
		$new_password = md5($this->input->post("new_password")); 
		
		$_id = $this->session->userdata('_id');

		//로그인 모델 확인 전달 되는 값 (세션의 이메일, password)
		$result = $this->Board_model->login_select($old_email,$old_password);

		if(isset($result->_id))
		{
			//비밀번호가 맞으니까 정보 업데이트 해줌
			$this->Board_model->member_update($_id,$new_email,$new_password);
			header("Location: /index.php/member/login?msg=새로 로그인해 주세요");
		}
		else 
		{
			header("Location: /index.php/member/update?msg=비밀번호가 틀렸어");
		}
 
	}
}
