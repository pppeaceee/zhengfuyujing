<?php
	class indexModel{
		public function yujing(){
			$sql = "select * from yj WHERE state=1 ORDER BY data_time DESC LIMIT 0,10";
			return DB::findAll($sql);
		}
		public function dizheng(){
			$sql = "";
		}
	}
?>