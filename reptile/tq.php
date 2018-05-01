<?php
	// require "phpQuery/phpQuery.php";
	// require "db_fns.php";
	class GetHTML_tq{
		function  __construct($url){
			$this->url = $url;
			$this->db = 0;
			connect_db($this->db);
		}
		public function islink(){
			$context    = file_get_contents($this->url);
		    $ch="^[0-9]{9}-[0-9]{14}-[0-9]{4}.html^";
		    preg_match_all($ch,$context,$array2); 
		    $array3=array_unique($array2);
		    $i = 0;
		    foreach($array3 as $values){
		        foreach($values as $value){
        			$time_now=$this->getMillisecond();
        			$url_new="http://product.weather.com.cn/alarm/webdata/".$value."?_="."{$time_now}";
        			$context1=file_get_contents($url_new);
        			if($i < 20 && strpos($context1,"ALERTID") == false){echo "错误".$i++;continue;}

        			$h=explode("ALERTID",$context1);
			        preg_match_all("/[\x80-\xff]+/", $h[0],$title);
			        $h=explode("PROVINCE",$h[1]);
			        preg_match_all("/[\x80-\xff]+/", $h[0],$type);
			        $h=explode("CITY",$h[1]);
			        preg_match_all("/[\x80-\xff]+/", $h[0],$province);
			        $h=explode("STATIONNAME",$h[1]);
			        preg_match_all("/[\x80-\xff]+/", $h[0],$city);
			        $h=explode("SIGNALTYPE",$h[1]);
			        preg_match_all("/[\x80-\xff]+/", $h[0],$stationname);
			        $h=explode("SIGNALLEVEL",$h[1]);
			        preg_match_all("/[\x80-\xff]+/", $h[0],$type);
			        $h=explode("TYPECODE",$h[1]);
			        preg_match_all("/[\x80-\xff]+/", $h[0],$level);
			        $h=explode("ISSUETIME",$h[1]);
			        preg_match_all("^[0-9]{2}^",$h[0],$type_level);
			        $h=explode("ISSUECONTENT",$h[1]);
			        $time=$h[0];
			        $time=str_replace('":"',"",$time);
			        $time=str_replace('","',"",$time);
			        $h=explode("UNDERWRITER",$h[1]);
			        $content=$h[0];
			        $content=str_replace('":"',"",$content);
			        $content=str_replace('","',"",$content);
			        preg_match_all("/(\S{6}){$type[0][0]}/",$title[0][0],$zhuantai);
			        $zhuantai = $zhuantai[1][0];
			        if($zhuantai != "发布" && $zhuantai != "解除"){
			        	echo "数据异常\n";
			        	die;
			        }
			        preg_match_all("/(\S*){$zhuantai}/",$title[0][0],$area);
			        $area = $area[1][0];
			        $image="http://www.weather.com.cn/m2/i/about/alarmpic/".$type_level[0][0].$type_level[0][1].".gif";
			        if($type_level[0][0] == "94")$image = "http://www.weather.com.cn/m2/i/about/alarmpic/1201.gif";
			        $result = mysqli_query($this->db,"SELECT * FROM yj WHERE title='{$title[0][0]}' and level='{$level[0][0]}' and area='{$area}' and type='{$type[0][0]}' and data_time='{$time}' and zhuantai='{$zhuantai}' ORDER BY id DESC");
					$row=mysqli_fetch_assoc($result);
					if(isset($row)){
						echo "已有数据   ".$title[0][0]."\n\n";
						sleep(2);
						continue;
					}
			        $sql = "INSERT INTO `yj`(`url`,`title`,`area`,`type`,`level`,`zhuantai`,`content`,`data_time`,`image`)values('{$url_new}','{$title[0][0]}','{$area}','{$type[0][0]}','{$level[0][0]}','{$zhuantai}','{$content}','{$time}','{$image}')";
			        // echo $sql."\n";
			        echo $title[0][0]."\n";
			        mysqli_query($this->db,$sql);
			        // die;
			        sleep(2);
		        }
		    }
		    echo "天气预警,爬取完毕\n";
		}
		public function getMillisecond() {
		    list($t1, $t2) = explode(' ', microtime());
		    return $t2 .  ceil( ($t1 * 1000) );
		}
	}
	// $tq = new GetHTML_tq("http://product.weather.com.cn/alarm/grepalarm_cn.php?_=1517191777205");
	// $tq->islink();
?>