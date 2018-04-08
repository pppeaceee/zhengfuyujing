<?php
	class registerModel{
		public function register(){
			if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['province']) && isset($_POST['county'])){
				if($this->check($_POST['username'])){
					$pass = $_POST['password'];
					$_POST['password'] = md5($_POST['password']);
					DB::insert('user',$_POST);
					$_SESSION['username']=$_POST['username'];
					$_SESSION['password']=$pass;
					echo "true";
					//自动登录
					// session_start();
				}else{
					echo "false";
					//用户已存在
				}
			}else{
				echo "error";
			}
		}
		public function check($user){
			$sql = "SELECT * from user where username = '{$user}'";
			$result = DB::findOne($sql);
			if(isset($result)){
				return 0;
			}else return 1;
		}
	}
?>