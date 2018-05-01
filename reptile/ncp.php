<?php
	require "phpQuery/phpQuery.php";
	class GetHTML{
		public function __construct($url){
			$this->url = $url;
			$this->type = ['番茄'];
		}
		public function start(){
			for($i = 0;$i < count($this->type);$i++){
				for($page = 1;$page < 100;$page++){
					$url = sprintf($this->url,$this->type[$i],$page);
					$content = file_get_contents($url);
					$pagedata = phpQuery::newDocumentHTML($content);
					$doc = phpQuery::pq("");
					$data = $doc->find("")->text();
					print_r($data);
					// foreach ($data as $value) {
					// 	print("1");
					// }
					die;
				}
			}
		}
	}
	$html = new GetHTML("https://s.zgny.com.cn/Search_m.aspx?SearchName=%s&lm=2&page=%d");
	$html->start();
?>