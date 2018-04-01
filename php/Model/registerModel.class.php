<?php
	class registerModel{
		public function register(){
			if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['province']) && isset($_POST['city']) && isset($_POST['county'])){
				// print_r($_POST);
				if($this->check($_POST['username'])){
					DB::insert('user',$_POST);
					echo "注册成功";
					//自动登录
				}else{
					echo "存在";
					//用户已存在
				}
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