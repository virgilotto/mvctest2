<?php

	class UserModel{

		function __construct($consetup){
			$this->host = $consetup->host;
			$this->user = $consetup->user;
			$this->pass =  $consetup->pass;
			$this->db = $consetup->db;
		}

		public function open_db(){
			$this->condb=new mysqli($this->host,$this->user,$this->pass,$this->db);
			if ($this->condb->connect_error)
			{
    			die("Erron in connection: " . $this->condb->connect_error);
			}
		}

		public function close_db(){ $this->condb->close(); }


		public function insertRecord($obj){
			try
			{
				$this->open_db();
				$query=$this->condb->prepare("INSERT INTO user (username,first_name,last_name,email) VALUES (?, ?, ?, ?)");
				$query->bind_param("ssss",$obj->username,$obj->first_name,$obj->last_name,$obj->email);
				$query->execute();
				$res= $query->get_result();
				$last_id=$this->condb->insert_id;
				$query->close();
				$this->close_db();
				return $last_id;
			}
			catch (Exception $e){ $this->close_db(); throw $e; }
		}

		public function updateRecord($obj){
			try
			{
				$this->open_db();
				$query=$this->condb->prepare("UPDATE user SET username=?,first_name=?,last_name=?,email=? WHERE iduser=?");
				$query->bind_param("ssss",$obj->username,$obj->first_name,$obj->last_name,$obj->email);
				$query->execute();
				$res=$query->get_result();
				$query->close();
				$this->close_db();
				return true;
			}
			catch (Exception $e){ throw $e; }
        }

		public function deleteRecord($id){
			try{
				$this->open_db();
				$query=$this->condb->prepare("DELETE FROM user WHERE iduser=?");
				$query->bind_param("i",$id);
				$query->execute();
				$res=$query->get_result();
				$query->close();
				$this->close_db();
				return true;
			}
			catch (Exception $e){ throw $e; }
        }

		public function selectRecord($id){
			try
			{
                $this->open_db();
                if($id>0){
					$query=$this->condb->prepare("SELECT * FROM user WHERE iduser=?");
					$query->bind_param("i",$id);
				}
                else
                {$query=$this->condb->prepare("SELECT * FROM user");	}

				$query->execute();
				$res=$query->get_result();
				$query->close();
				$this->close_db();
                return $res;
			}
			catch(Exception $e){ throw $e; }

		}
	}

?>