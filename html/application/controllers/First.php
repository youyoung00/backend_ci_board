<?php
// defined 는 제어권을 프레임워크가 가져가기 위한 코드. 대부분의 파일에 적용됨.
defined('BASEPATH') OR exit('No direct script access allowed'); 

class First extends CI_Controller {

	public function index()
	{
		echo "내가 만든 첫번째 컨트롤러. ";
	}

	public function my()
	{
		echo "내꺼야";
	}

}
