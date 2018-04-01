<?php
	class loginModel{
		public function login(){
			if(isset($_POST['username']) && isset($_POST['password'])){
				if($pass = $this->check($_POST['username'])){
					if($pass == $_POST['password']){
						echo "密码正确";
						//自动登录
					}else{
						echo "密码错误";
					}
				}else{
					echo "不存在";
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