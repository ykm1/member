<?php
require_once 'dto.php';
class HobbyDao{
	private $conn = null;
	
	public function connect(){			//db 연결하는 함수
		try{
			$this->conn = new PDO('mysql:host=localhost;dbname=mydb;charset=utf8', 'hr', 'hr');
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}catch (PDOException $e){
			print $e->getMessage();
		}
	}
	public function disconnect(){		//db 끊어주는 함수
		$this->conn = null;
	}
	public function selectAll(){
		$arr = array();
		$this->connect();
		$sql = "select * from hobby";
		$result = null;
		try{
			$result = $this->conn->query($sql);
			$cnt = $result->rowCount();
			if($cnt>0){
				while($row = $result->fetch(PDO::FETCH_ASSOC)){
					$arr[] = new Hobby($row['id'], $row['name']);
				}
			}
		}catch (Exception $e){
			print $e->getMessage();
		}
		$this->disconnect();
		return $arr;
	}
}

class MemberDao{
	private $conn = null;
	
	public function connect(){			//db 연결하는 함수
		try{
			$this->conn = new PDO('mysql:host=localhost;dbname=mydb;charset=utf8', 'hr', 'hr');
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}catch (PDOException $e){
			print $e->getMessage();
		}
	}
	public function disconnect(){		//db 끊어주는 함수
		$this->conn = null;
	}
	public function insert($m){
		$this->connect();
		try{
			$sql = "insert into member values(?,?,?,?,?,?)";		//변수를 물음표로 표시
			$stm = $this->conn->prepare ($sql);
			$stm->bindValue (1, $m->getId ());						//bindValue : 입력할 위치 확보와 확정된 값을 매칭
			$stm->bindValue (2, $m->getPwd ());
			$stm->bindValue (3, $m->getName ());
			$stm->bindValue (4, $m->getEmail ());
			$stm->bindValue (5, $m->getHobby ());
			$stm->bindValue (6, $m->getMsg ());
			$stm->execute();										//sql 실행
		}catch (PDOException $e){									//PDO객체만 관련된 예외만 받겠다 (Exception이 더 상위:더많은 예외받음)
			print $e->getMessage();
		}
		$this->disconnect();
	}
	public function select($id){
		$m = null;
		$this->connect();
		try{
			$sql = "select * from member where id=?";
			$stm = $this->conn->prepare ($sql);
			$stm->bindValue (1, $id);
			$stm->execute();							//검색한 결과가 statement객체에 저장이 된다
			$cnt = $stm->rowCount();
			if($cnt >0){								//결과가 있을 때만 $m에 멤버객체로 반환하고 결과가 없다면 null로 반환하여 찾았는지 알 수 있음
				$row = $stm->fetch(PDO::FETCH_ASSOC);
				$m = new Member($row['id'], $row['pwd'], $row['name'], $row['email'], $row['hobby'], $row['msg']);
			}	
		}catch (PDOException $e){
			print $e->getMessage();
		}
		$this->disconnect();
		return $m;
	}
	
	public function selectAll($id){						//!imgboard에서 파도타기를 위한 자신과 다른 아이디를 가진 사람의 사진목록 검색
		$ids = array();
		$this->connect();
		try{
			$sql = "select id from member where id<>?";
			$stm = $this->conn->prepare ($sql);
			$stm->bindValue (1, $id);
			$stm->execute();
			$cnt = $stm->rowCount();
			if($cnt >0){
				while ($row = $stm->fetch(PDO::FETCH_ASSOC)){
					$ids[] = $row['id'];
				}
			}
		}catch (PDOException $e){
			print $e->getMessage();
		}
		$this->disconnect();
		return $ids;
	}
	
	public function update($m){
		$this->connect();
		try{
			$sql = "update member set pwd=?, email=?, hobby=?, msg=? where id=?;";		
			$stm = $this->conn->prepare ($sql);
			$stm->bindValue (1, $m->getPwd ());
			$stm->bindValue (2, $m->getEmail ());
			$stm->bindValue (3, $m->getHobby ());
			$stm->bindValue (4, $m->getMsg ());
			$stm->bindValue (5, $m->getId ());
			$stm->execute();										
		}catch (PDOException $e){									
			print $e->getMessage();
		}
		$this->disconnect();
	}
	public function delete($id){
		$this->connect();
		try{
			$sql = "delete from member where id=?;";
			$stm = $this->conn->prepare ($sql);
			$stm->bindValue (1, $id);
			$stm->execute();
		}catch (PDOException $e){
			print $e->getMessage();
		}
		$this->disconnect();
	}
}
?>