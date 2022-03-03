<?php
// defined 는 제어권을 프레임워크가 가져가기 위한 코드. 대부분의 파일에 적용됨.
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function test()
	{
		echo "여기는 테스트 페이지입니다. ";
	}
}
