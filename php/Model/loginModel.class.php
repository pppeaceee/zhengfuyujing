<?php
	class loginModel{
		public function login(){
			if(isset($_POST['user']) && isset($_POST['pass'])){
				if($pass = $this->check($_POST['user'])){
					if($pass == $_POST['pass']){
						echo "密码正确";
						//自动登录
					}else{
						echo "密码错误";
					}
				}else{
					//用户不存在
				}
			}
		}
		public function check($user){
			$sql = "SELECT * from user where user = '{$user}'";
			$result = DB::findOne($sql);
			if(isset($result)){return $result['pass'];}
			else return 0;
		}
	}
?>