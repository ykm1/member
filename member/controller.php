<?php
require_once 'service.php';
class MemberController{
	private $hService;
	private $mService;
	private $action;
	private $data;
	private $view;
	private $m;
	
	public function __construct($action){
		$this->hService = new HobbyService();
		$this->mService = new MemberService();
		$this->action = $action;
	}
	public function run(){
		switch ($this->action){
			case "idCheck":
				$this->idCheck();
				break;
			case "join":
				$this->join();
				break;
			case "login":
				$this->login();
				break;
			case "editInfo":
				$this->editInfo();
				break;
			case "myInfo":
				$this->myInfo();
				break;
			case "logout":
				$this->logout();
				break;
			case "out":
				$this->out();
				break;
			case "joinform":
				$this->joinform();
				break;
		}
		require 'view/'.$this->view;
	}
	public function idCheck(){
		$m = $this->mService->getMember($_REQUEST['id']);
		if($m == null){
			$this->data = "true";
		}else{
			$this->data = "false";
		}
		$this->view = "idCheck.php";
	}
	public function join(){
		$str = implode(",", $_POST['hobby']);
		$m = new Member($_POST['id'],$_POST['pwd'],$_POST['name'],$_POST['email'],$str,$_POST['msg']);
		$this->mService->join($m);
		$this->view = "loginform.php";
	}
	public function hobbyList(){
		$this->data = $this->hService->getAll();
	}
	public function joinform(){ 
		$this->hobbyList();
		$this->view = "joinform.php";
	}
	public function login(){
		$code = $this->mService->login($_POST['id'], $_POST['pwd']);
		switch ($code){
			case 1:
				$this->data = '없는 아이디';
				$this->view = 'loginform.php';
				break;
			case 2:
				$this->data = '잘못된 패스워드';
				$this->view = 'loginform.php';
				break;
			case 3:
				$this->data = '로그인 성공';
				$this->view = 'main.php';
				break;
		}
	}
	public function myInfo(){
		$id = $_GET['id'];
		$this->m = $this->mService->getMember($id);
		$this->hobbyList();
		$this->view = 'editform.php';
	}
	public function editInfo(){
		$str = implode(",", $_POST['hobby']);
		$m = new Member($_POST['id'],$_POST['pwd'],'',$_POST['email'],$str,$_POST['msg']);
		$this->mService->editInfo($m);
		$this->view = "main.php";
	}
	public function logout(){
		$this->mService->logout();
		$this->view = 'loginform.php';
	}
	public function out(){
		$this->mService->out();
		$this->view = 'loginform.php';
	}
}
?>