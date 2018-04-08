<?php
	class loginModel{
		public function login(){
			if(isset($_POST['username']) && isset($_POST['password'])){
				if($pass = $this->check($_POST['username'])){
					if($pass == md5($_POST['password'])){
						echo "true";
						//自动登录
						// session_start();
						$_SESSION['username']=$_POST['username'];
						$_SESSION['password']=$_POST['password'];
						// echo "<script>window.location.href='http://localhost';</script>";
					}else{
						echo "false";
					}
				}else{
					echo "error";
					//用户不存在
				}
			}
		}
		public function check($user){
			$sql = "SELECT * from user where username = '{$user}'";
			$result = DB::findOne($sql);
			if(isset($result)){return $result['password'];}
			else return 0;
		}
	}
?>