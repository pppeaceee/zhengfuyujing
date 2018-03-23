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
			for($i = 0;$i < count($data);$i++) {
				foreach($data[$i] as $key => $value){
					// echo $key . "[{$i}]=>" .$value."<br>";
					$page = str_replace("{".$key."[".$i."]"."}",$value,$page);
				}
			}
			echo $page;
		}
	}
?>