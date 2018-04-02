<?php
	class pageModel{
		public function page(){
			$page = ($_GET['page']-1)*10;
			$sql = "select * from yj WHERE state=1 ORDER BY data_time DESC LIMIT {$page},10";
			$data = DB::findAll($sql);
			return $data;
		}
	}
?>