<?php
	class demoview{
		//view属性变量

		public function assign($key,$value){

		}
		public function display($data){
			$data = file_get_contents($data);
			echo $data;
		}
		public function display_var($url,$data){
			$page = file_get_contents($url);
			foreach($data as $key => $value){
				// echo $key . "=>" .$value."<br>";
				$page = str_replace("{".$key."}",$value,$page);
			}
			echo $page;
		}
	}
?>