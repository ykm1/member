<?php
require_once 'dao.php';
class HobbyService{							//hobby 테이블 기능
	private $dao;
	public function __construct(){
		$this->dao = new HobbyDao();
	}
	public function getAll(){
		return $this->dao->selectAll();
	}
}
class MemberService{						//member 테이블 기능
	private $dao;
	public function __construct(){
		$this->dao = new MemberDao();
	}
	public function join($m){
		$this->dao->insert($m);		
	}
	public function login($id,$pwd){
		$m = $this->dao->select($id);
		if($m==null){
			return 1;
		}else{
			if($m->getPwd()==$pwd){
				session_start();
				$_SESSION['id']=$id;
				return 3;
			}else{
				return 2;
			}
		}
	}
	public function logout(){
		if(session_status()!=PHP_SESSION_ACTIVE){				//세션의 현재값을 반환_실행중인지 확인
		session_start();
		}
		session_unset();
		session_cache_expire(60);
		session_destroy();
	}
	public function out(){
		if(session_status()!=PHP_SESSION_ACTIVE){
		session_start();
		}
		if(isset($_SESSION['id'])){
			$this->dao->delete($_SESSION['id']);
			$this->logout();
		}
	}
	public function editInfo($m){
		$this->dao->update($m);
	}
	public function getMember($id){
		return $this->dao->select($id);
	}
	public function getIds($id){							//!자신의 목록을 뺀 나머지 아이디 검색
		return $this->dao->selectAll($id);
	}
}
?>