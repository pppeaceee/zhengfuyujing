<?php
	class GetHTML_dz{
		function __construct($url){
			$this->url = $url;
			connect_db($this->db);
		}
		public function islink(){
			foreach(range(1,20) as $page){
				$url = sprintf($this->url,$page);
				$this->get_info($url);
				sleep(8);
			}
			echo "地震数据,爬取完毕\n";
		}
		public function get_info($url){
			// $ch = curl_init();
			// curl_setopt($ch, CURLOPT_FAILONERROR, false);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
			// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// 	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			// }
			// curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:106.18.238.143', 'CLIENT-IP:106.18.238.143'));  
			// curl_setopt($ch, CURLOPT_REFERER, $url);
			// curl_setopt($ch, CURLOPT_PROXY, "http://106.18.238.143");
			// curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11");
			// curl_setopt($ch, CURLOPT_URL, $url);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// curl_setopt($ch, CURLOPT_HEADER, 0);
			// $context = curl_exec($ch);
			// curl_close($ch);
			// print_r($context);
			// die;
			$context = file_get_contents($url);
		    $ch='^CD[0-9]{14}"^';
		    preg_match_all($ch,$context,$array2); 
		    $array3=array_unique($array2,SORT_REGULAR );
		    foreach($array3 as $values){
		        foreach($values as $value){
			        $value=str_replace('"',"",$value);
			        $url_new="http://news.ceic.ac.cn/".$value.".html";
			        $context1 = file_get_contents($url_new);
			        $document   = phpQuery::newDocumentHTML($context1);
			        $doc        = phpQuery::pq("");
			        $table = $doc->find("table");
			        $time=pq($doc)->find("tr>td:eq(0)")->text();
			        $weidu=pq($doc)->find(" tr> td:eq(1)")->text();
			        $jingdu=pq($doc)->find("tr>td:eq(2)")->text();
			        $deep=pq($doc)->find("tr>td:eq(3)")->text();
			        $level=pq($doc)->find("tr>td:eq(4)")->text();
			        $area=pq($table)->find("td:eq(5)")->text();
			        $title=pq($doc)->find("body > div > div.main > div > div > h1")->text();
			        $time = str_replace("\n","",$time);
			        $time = str_replace(" ","",$time);
			        // echo $url_new."\n";
			        // echo $time;
			        // echo $weidu;
			        // echo $jingdu;
			        // echo $deep;
			        // echo $level;
			        // echo $area;
			        // echo $title."\n";
			        $result = mysqli_query($this->db,"SELECT * FROM dz WHERE title='{$title}' and level='{$level}' and area='{$area}' and data_time='{$time}' ORDER BY id DESC");
					$row=mysqli_fetch_assoc($result);
					if(isset($row)){
						echo "已有数据   ".$title."\n\n";
						sleep(2);
						continue;
					}
					$sql = "INSERT INTO `dz` (`url`, `title`, `level`, `data_time`, `longitude`, `latitude`, `deep`, `area`) VALUES ('{$url_new}','{$title}','{$level}','{$time}','{$jingdu}','{$weidu}','{$deep}','{$area}')";
			        echo $title."\n";
			        mysqli_query($this->db,$sql);
			        sleep(2);
			    }
			}
		}
	}
?>