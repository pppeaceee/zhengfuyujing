<?php
	class searchModel{
		public function search(){
			$search = str_replace($_POST['province'],"",$_POST['search']);
			$search = str_replace($_POST['city'],"",$search);
			$search = str_replace($_POST['district'],"",$search);
			if($_POST['city'] == "市辖区" || $_POST['city'] == "郊县")$_POST['city'] = "";

			$sql = "SELECT * from yj where area like '%{$_POST['province']}{$_POST['city']}{$_POST['district']}%' and title like '%{$search}%'";
			$result = DB::findAll($sql);
			$data[0]['title'] = "预警搜索结果&nbsp;&nbsp;&nbsp;&nbsp;<button style='float:right;color:black;background-color:white;width:70px;border:1px solid white' onclick='page();'>返回</button>";
			$data[0]['page'] = ceil(count($result)/10);
			$sql = "SELECT * from yj where area like '%{$_POST['province']}{$_POST['city']}{$_POST['district']}%' and title like '%{$search}%' ORDER BY data_time DESC LIMIT 0,10";
			// echo $sql;
			$result = DB::findAll($sql);
			$data[0]['warn_data'] = "";
			$i = 0;
			foreach($result as $value){
				if($this->isfile($value['image'])==0)$value['image']="http://www.weather.com.cn/m2/i/about/alarmpic/1201.gif";
				$data[0]['warn_data'] .= "<div class='panel panel-default'>
                                            <div class='panel-heading' role='tab' id='heading{$i}'>
                                                <h4 class='panel-title'>
                                                    <a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#collapse{$i}' aria-expanded='false'
                                                        aria-controls='collapse{$i}'>
                                                        <img src='{$value['image']}' style='float:left' width='25px'>{$value['title']}
                                                        <span>{$value['data_time']}</span>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id='collapse{$i}' class='panel-collapse collapse' role='tabpanel' aria-labelledby='heading{$i}'>
                                                <div class='panel-body'>
                                                    {$value['content']}
                                                </div>
                                            </div>
                                        </div>";
                                        $i++;
			}
			$data = json_encode($data);
			echo $data;
		}
		public function search_page(){
			$page = ($_POST['page']-1)*10;
			$search = str_replace($_POST['province'], "",$_POST['search']);
			$search = str_replace($_POST['city'], "",$search);
			$search = str_replace($_POST['district'], "",$search);
			if($_POST['city'] == "市辖区" || $_POST['city'] == "郊县")$_POST['city'] = "";
			$sql = "SELECT * from yj where area like '%{$_POST['province']}{$_POST['city']}{$_POST['district']}%' and title like '%{$search}%' ORDER BY data_time DESC LIMIT {$page},10";
			$result = DB::findAll($sql);
			$data[0]['warn_data'] = "";
			$i = 0;
			foreach($result as $value){
				if($this->isfile($value['image'])==0)$value['image']="http://www.weather.com.cn/m2/i/about/alarmpic/1201.gif";
				$data[0]['warn_data'] .= "<div class='panel panel-default'>
                                            <div class='panel-heading' role='tab' id='heading{$i}'>
                                                <h4 class='panel-title'>
                                                    <a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#collapse{$i}' aria-expanded='false'
                                                        aria-controls='collapse{$i}'>
                                                        <img src='{$value['image']}' style='float:left' width='25px'>{$value['title']}
                                                        <span>{$value['data_time']}</span>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id='collapse{$i}' class='panel-collapse collapse' role='tabpanel' aria-labelledby='heading{$i}'>
                                                <div class='panel-body'>
                                                    {$value['content']}
                                                </div>
                                            </div>
                                        </div>";
                                        $i++;
			}
			$data = json_encode($data);
			echo $data;
		}
		public function isfile($url) {
	        $ch = curl_init(); 
	        curl_setopt ($ch, CURLOPT_URL, $url); 
	        //不下载
	        curl_setopt($ch, CURLOPT_NOBODY, 1);
	        //设置超时
	        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 3); 
	        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
	        curl_exec($ch);
	        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
	        if($http_code == 200) {
	            return 1;
	        }
	        return 0;
	    }
	}
?>