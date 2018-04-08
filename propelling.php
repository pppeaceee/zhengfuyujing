<?php
	class propelModel{
		public function __construct(){
			$this->db = mysqli_connect("localhost:3306","root","","tqyj");
			mysqli_query($this->db,"set names 'utf8'");
		}
		public function start(){
			while(true){
				$this->user_propel();
				sleep(5);
			}
		}
		public function user_propel(){
			$sql = "SELECT * from `user` where root = 0";
			$result = mysqli_query($this->db,$sql);
			while($data = mysqli_fetch_array($result,MYSQLI_ASSOC)){
				if($data['city'] == "市辖区" || $data['city'] == "郊县")$data['city'] = "";
				$time = date('Y-m-d');
				$sql = "SELECT * from yj where (area LIKE '%{$data['province']}%{$data['county']}%' or area LIKE '%{$data['province']}%{$data['city']}%') and zhuantai='发布' and data_time >= '{$time}' ORDER BY data_time DESC";
				$result_yj = mysqli_query($this->db,$sql);
				while($data_yj = mysqli_fetch_array($result_yj,MYSQLI_ASSOC)){
					if($this->isexist($data['id'],$data_yj['id'])==0){
						$content = "尊敬的用户，你所在的地区{$data_yj['area']}{$data_yj['zhuantai']}了{$data_yj['level']}{$data_yj['type']}，请做好防范！";
						$sql = "insert into reply(`user_id`,`warn_id`,`user`,`content`)values('{$data['id']}','{$data_yj['id']}','{$data['username']}','{$content}')";
						mysqli_query($this->db,$sql);
						echo $data_yj['title']."\n";
					}
				}
				// echo $sql."\n";
				// sleep(5);
			}
		}
		public function isexist($user_id,$data_id){
			$sql = "SELECT id FROM reply where user_id = {$user_id} and warn_id = {$data_id}";
			$result = mysqli_query($this->db,$sql);
			// print_r($result);
			if($result->num_rows > 0)return 1;
			else if($result->num_rows == 0)return 0;
		}
	}
	$propel = new propelModel();
	$propel->start();
?>