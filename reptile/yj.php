<?php
	class GetHTML_yj{
		function __construct($url){
			$this->url = $url;
			connect_db($this->db);
		}
		public function islink(){
			for($i=1;$i<=40;$i++){
				$url = sprintf($this->url,$i);
				$this->get_link($url);
			}
			echo "预警数据,爬取完毕";
		}
		public function get_link($url){
			$page = file_get_contents($url);
			$pagedata = phpQuery::newDocumentHTML($page);
			$doc = phpQuery::pq("");
			$text_box = $doc->find("ul.newslist_yj > li");
			foreach($text_box as $value){
				$link = pq($value)->find("p > a")->attr("href");
				$this->get_info($link);
				sleep(2);
			}
		}
		public function get_info($url){
			$page = file_get_contents($url);
			$document=phpQuery::newDocumentHTML($page);
		    $doc=phpQuery::pq("");
		    $title = $doc->find("div.left650 > div > h1")->text();
		    $time = $doc->find("div.left650 > div > div.time")->text();
		    $ch='/\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}:\d{2}/';
		    preg_match_all($ch,$time,$time);
		    $time = $time[0][0];
		    $content = $doc->find("div.left650 > div > div#newscont p:eq(1)")->text();

			if(strpos($title,"发布")){
				preg_match_all("/(\S*)发布/",$title,$area);
				$zhuantai = "发布";
			}else if(strpos($title,"解除")){
				preg_match_all("/(\S*)解除/",$title,$area);
				$zhuantai = "解除";
			}
			$area = $area[1][0];
			preg_match_all("/{$zhuantai}(\S*)色/",$title,$level);
			$level = $level[1][0];
			preg_match_all("/{$level}色(\S*)预警/",$title,$type);
			$type = $type[1][0];
		    $py = $this->pinyin($type);
		    $num = $this->color_level($level);
		    $level = $level."色";
		    $image = "http://www.tianqi.com/static/img/yujing_img/big".$py."_ico".$num.".jpg";

		    $result = mysqli_query($this->db,"SELECT * FROM yj WHERE title='{$title}' and level='{$level}' and area='{$area}' and type='{$type}' and data_time='{$time}' and zhuantai='{$zhuantai}' ORDER BY id DESC");
			$row=mysqli_fetch_assoc($result);
			if(isset($row)){
				echo "已有数据   ".$title."\n\n";
				return;
			}
		    $sql = "INSERT INTO `yj`(`url`,`title`,`area`,`type`,`level`,`zhuantai`,`content`,`data_time`,`image`)values('{$url}','{$title}','{$area}','{$type}','{$level}','{$zhuantai}','{$content}','{$time}','{$image}')";
		    // echo $url."\n";
		    echo $title."\n";
		    // echo $area."\n";
		    // echo $time."\n";
		    // echo $type."\n";
		    // echo $level."\n";
		    // echo $zhuantai."\n";
		    // echo $image."\n";
		    // echo $content."\n";
		    // echo $sql;
		    mysqli_query($this->db,$sql);
		    // die;
		}
		public function color_level($ch){
			if($ch == "蓝")return 1;
			else if($ch == "黄")return 2;
			else if($ch == "橙")return 3;
			else if($ch == "红")return 4;
			else return false;
		}
		public function city($ch){
			if(strpos($ch,"发布")){
				preg_match_all("/(\S*)发布/",$ch,$area);
			}else if(strpos($ch,"解除")){
				preg_match_all("/(\S*)解除/",$ch,$area);
			}
			return $area[1][0];
		}
		public function pinyin($ch){
			switch($ch){
				case "台风":return "taifeng";
				case "暴雨":return "baoyu";
				case "暴雪":return "baoxue";
				case "寒潮":return "hanchao";
				case "大风":return "dafeng";
				case "高温":return "gaowen";
				case "雷电":return "leidian";
				case "霜冻":return "shuangdong";
				case "大雾":return "dawu";
				case "冰雹":return "bingbao";
				case "干旱":return "ganhan";
				case "霾":return "mai";
				case "道路结冰":return "daolujiebing";
				default : return "false";
			}
		}
	}
	// $html->get_info("http://www.tianqi.com/alarmnews/1803152145102641.html");
?>