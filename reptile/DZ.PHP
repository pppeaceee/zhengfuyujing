<?php
	require "phpQuery/phpQuery.php";
	require "db_fns.php";
	class GetHTML{
		function __construct($url){
			$this->url = $url;
			connect_db($this->db);
		}
		public function islink(){
			foreach(range(1,10) as $page){
				$url = sprintf($this->url,$page);
				$this->get_info($url);
				sleep(5);
			}
		}
		public function get_info($url){
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
						sleep(1);
						continue;
					}
					$sql = "INSERT INTO `dz` (`url`, `title`, `level`, `data_time`, `longitude`, `latitude`, `deep`, `area`) VALUES ('{$url_new}','{$title}','{$level}','{$time}','{$jingdu}','{$weidu}','{$deep}','{$area}')";
			        echo $title."\n";
			        mysqli_query($this->db,$sql);
			        sleep(1);
			    }
			}
		}
	}
	$html = new GetHTML("http://www.ceic.ac.cn/ajax/search?page=%d&&start=&&end=&&jingdu1=73&&jingdu2=136&&weidu1=3&&weidu2=54&&height1=&&height2=&&zhenji1=&&zhenji2=&&callback=jQuery18006096551879017713_1517193281934&_=1517193679279");
	$html->islink();
?>