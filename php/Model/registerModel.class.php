<?php
	class registerModel{
		public function register(){
			if(isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['address'])){
				if($this->check($_POST['user'])){
					$arr = $this->arr_form($_POST['user'],$_POST['pass'],$_POST['address']);
					DB::insert('user',$arr);
					echo "注册成功";
					//自动登录
				}else{
					//用户已存在
				}
			}
		}
		public function check($user){
			$sql = "SELECT * from user where user = '{$user}'";
			$result = DB::findOne($sql);
			if(isset($result)){
				return 0;
			}else return 1;
		}
		public function arr_form($user,$pass,$address){
			$arr['user']=$user;
			$arr['pass']=$pass;
			$arr['address']=$address;
			return $arr;
		}
	}
?>