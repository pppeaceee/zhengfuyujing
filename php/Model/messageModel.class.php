<?php
	class messageModel{
		public function message_send(){
			if($_POST['email'] != "" && $_POST['content'] != ""){
				$data['user_id'] = 0;
				$data['user']=$_POST['email'];
				$data['content'] = $_POST['content'];
				DB::insert('message',$data);
				echo "true";
			}else echo "error";
		}
		public function del_message(){
			$arr['statue'] = 0;
			DB::update('reply',$arr,"id={$_POST['id']}");
			echo "true";
		}
	}
?>