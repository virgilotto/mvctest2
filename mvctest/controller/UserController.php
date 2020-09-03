<?php
    require 'model/UserModel.php';
    require 'model/User.php';
    require_once 'database_updates/config.php';

    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

	class UserController{

 		function __construct(){
			$this->objconfig = new config();
			$this->objum =  new UserModel($this->objconfig);
		}

		public function mvcHandler()
		{
			$act = isset($_GET['act']) ? $_GET['act'] : NULL;
			switch ($act){
                case 'add' : $this->insert(); break;
				case 'update': $this->update(); break;
				case 'delete' : $this -> delete(); break;
				default: $this->list();
			}
		}

		public function pageRedirect($url){ header('Location:'.$url); }

		public function checkValidation($userT) {
			$noerror=true;
            if(empty($userT->username)){
				$noerror=false;
            }
            return $noerror;
        }

		public function insert(){
            try{
                $userT=new User();
                if (isset($_POST['addbtn'])){
                    $userT->username = trim($_POST['username']);
                    $chk=$this->checkValidation($userT);
                    if($chk){
                        $pid = $this->objum->insertRecord($userT);
                        if($pid>0){
                            $this->list();
                        }else{
                            echo "Error. Please try again.";
                        }
                    }else{
                        $_SESSION['userT1']=serialize($userT);
                        $this->pageRedirect("view/insert.php");
                    }
                }
            }catch (Exception $e) { $this->close_db(); throw $e; }
        }

        public function update(){
            try{

                if (isset($_POST['updatebtn'])){
                    $userT=unserialize($_SESSION['userT1']);
                    $userT->id = trim($_POST['id']);
                    $userT->username = trim($_POST['username']);
                    $chk=$this->checkValidation($userT);
                    if($chk)
                    {
                        $res = $this->objum->updateRecord($userT);
                        if($res){
                            $this->list();
                        }else{
                            echo "Error. Please try again.";
                        }
                    }else
                    {
                        $_SESSION['userT1']=serialize($userT);
                        $this->pageRedirect("view/update.php");
                    }
                }elseif(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
                    $id=$_GET['id'];
                    $result=$this->objum->selectRecord($id);
                    $row=mysqli_fetch_array($result);
                    $userT=new User();
                    $userT->id=$row["id"];
                    $userT->username=$row["username"];
                    $_SESSION['userT1']=serialize($userT);
                    $this->pageRedirect('view/update.php');
                }else{
                    echo "Error updating.";
                }
            }
            catch (Exception $e){ $this->close_db(); throw $e; }
        }

        public function delete(){
            try{
                if (isset($_GET['id'])){
                    $id=$_GET['id'];
                    $res=$this->objum->deleteRecord($id);
                    if($res){
                        $this->pageRedirect('index.php');
                    }else{
                        echo "Error. Please try again.";
                    }
                }else{
					echo "Error deleting.";
                }
            }
            catch (Exception $e){ $this->close_db(); throw $e; }
        }
        public function list(){
            $result=$this->objum->selectRecord(0);
            include "view/list.php";
        }
    }


?>