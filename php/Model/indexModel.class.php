<?php
	class indexModel{
		public function yujing(){
			$sql = "select * from yj WHERE state=1 ORDER BY data_time DESC LIMIT 0,10";
			// $sql = "select * from yj WHERE state=1 ORDER BY data_time DESC";
			$data = DB::findAll($sql);
			foreach ($data as $value) {
				if($this->isfile($value['image'])==0)$value['image'] = "http://www.weather.com.cn/m2/i/about/alarmpic/1201.gif";
			}
			// print_r($data);
			return $data;
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
		public function dizheng(){
			//五条数据
			$sum = 5;
			//地震危险等级指数
			$level = 5;
			//危险排序指数
			$type = "level";
			//来源几天前的数据
			$day = -10;
			$day = $day." days";
			$time = date('Y-m-d',strtotime($day));
			$dz_time = date('Y-m-d',strtotime('-6 days'));
			// echo $time."\n";
			$sql = "select * from dz WHERE area != '蒙古' and data_time >= '{$time}' and level >= '{$level}' ORDER BY {$type} DESC LIMIT 0,{$sum}";
			$data = DB::findAll($sql);
			$sum -= count($data);
			$sql = "select * from dz WHERE area != '蒙古' and data_time >= '{$dz_time}' and level >= '4' ORDER BY {$type} DESC LIMIT 0,{$sum}";
			$result = DB::findAll($sql);
			$sum -= count($result);
			foreach ($result as $value) {
				$data[] = $value;
			}
			// print_r($sum);
			// print_r($data);
			// 预警信息是否要参与不推荐
			$yj_time = date('Y-m-d',strtotime('-1 days'));
			// echo $yj_time;
			$sql = "select * from yj where type='台风' and level='红色' and zhuantai = '发布' and data_time >= '{$yj_time}' and state = 1 ORDER BY data_time DESC LIMIT 0,{$sum}";
			$result = DB::findAll($sql);
			$sum -= count($result);
			foreach ($result as $value) {
				$data[] = $value;
			}
			$sql = "select * from yj where type='雷电' and level='红色' and zhuantai = '发布' and data_time >= '{$yj_time}' and state = 1 ORDER BY data_time DESC LIMIT 0,{$sum}";
			$result = DB::findAll($sql);
			$sum -= count($result);
			foreach ($result as $value) {
				$data[] = $value;
			}
			$sql = "select * from yj where type='冰雹' and level='红色' and zhuantai = '发布' and data_time >= '{$yj_time}' and state = 1 ORDER BY data_time DESC LIMIT 0,{$sum}";
			$result = DB::findAll($sql);
			$sum -= count($result);
			foreach ($result as $value) {
				$data[] = $value;
			}
			$sql = "select * from yj where type!='冰雹' and type!='雷电' and type!='台风' and level='红色' and zhuantai = '发布' and data_time >= '{$yj_time}' and state = 1 ORDER BY data_time DESC LIMIT 0,{$sum}";
			$result = DB::findAll($sql);
			$sum -= count($result);
			foreach ($result as $value) {
				$data[] = $value;
			}
			$sql = "select * from yj where level='橙色' and zhuantai = '发布' and data_time >= '{$yj_time}' and state = 1 ORDER BY data_time DESC LIMIT 0,{$sum}";
			$result = DB::findAll($sql);
			$sum -= count($result);
			foreach ($result as $value) {
				$data[] = $value;
			}
			return $data;
			// echo isset($data[0])."\n";
		}
		public function merge($a1,$a2){
			$data = array_merge($a1,$a2);
			return $data;
			// print_r($data);
		}
		public function view(){

			$data['statue']=1;
			DB::insert('view',$data);
		}
		public function autologin($data){
			// session_start();
			// print_r($data);
			if(isset($_SESSION['username']) && isset($_SESSION['password'])){
				if($pass = $this->check($_SESSION['username'])){
					if($pass == md5($_SESSION['password'])){
						$data[15]['nav']="<li class='active'><a href='#section-1'><span class='glyphicon glyphicon-home'></span>  首页</a></li>
                                  <li><a href='#section-2'><span class='glyphicon glyphicon-info-sign'></span>  资讯</a></li>
                                  <li><a href='#section-3'><span class='glyphicon glyphicon-fire'></span>  认识预警</a></li>                                  
                                  <li><a href='#section-4'><span class='glyphicon glyphicon-send'></span>  关于我们</a></li>
                                  <li><a href='#login1' data-toggle='modal' data-target='#personal'><span class='glyphicon glyphicon-user'></span>  个人中心</a></li>";
                        $data_msg = $this->msg_data($_SESSION['username']);
                        $data[15]['msg_num'] = count($data_msg);
                        $data[15]['username'] = $_SESSION['username'];
                        $data_user = $this->user_data($_SESSION['username']);
                        $data[15]['phone'] = $data_user['phonenumber'];
                        $data[15]['province'] = $data_user['province'];
                        $data[15]['city'] = $data_user['city'];
                        $data[15]['county'] = $data_user['county'];
                        if($this->check_root($_SESSION['username']) == 1)$data[15]['root'] = "<a href='admin.php?controller=admin&method=admin'>检测到您是管理员，可点此进入后台管理界面</a>";
                        else $data[15]['root'] = "";
                        $data[15]['msg_data'] = "";
                        $i = 1;
                        foreach ($data_msg as $value) {
                        	$data[15]['msg_data'] .= "<h4 class='mymessage10'> {$value['content']} <button class='btn btn-primary' onclick='del_msg({$value['id']});' id='delete{$i}' style='float:right'>删除</button></h4>";
                        	$i++;
                        }
					}else{
						echo "false";
						$data[15]['nav']="<li class='active'><a href='#section-1'><span class='glyphicon glyphicon-home'></span>  首页</a></li>
                                  <li><a href='#section-2'><span class='glyphicon glyphicon-info-sign'></span>  资讯</a></li>
                                  <li><a href='#section-3'><span class='glyphicon glyphicon-fire'></span>  认识预警</a></li>                                  
                                  <li><a href='#section-4'><span class='glyphicon glyphicon-send'></span>  关于我们</a></li>
                                  <li><a href='#' data-toggle='modal' data-target='#login1'><span class='glyphicon glyphicon-pencil'></span>  登录/注册</a></li>";
					}
				}else{
					echo "error";
					$data[15]['nav']="<li class='active'><a href='#section-1'><span class='glyphicon glyphicon-home'></span>  首页</a></li>
                                  <li><a href='#section-2'><span class='glyphicon glyphicon-info-sign'></span>  资讯</a></li>
                                  <li><a href='#section-3'><span class='glyphicon glyphicon-fire'></span>  认识预警</a></li>                                  
                                  <li><a href='#section-4'><span class='glyphicon glyphicon-send'></span>  关于我们</a></li>
                                  <li><a href='#' data-toggle='modal' data-target='#login1'><span class='glyphicon glyphicon-pencil'></span>  登录/注册</a></li>";
				}
			}else{
				$data[15]['nav']="<li class='active'><a href='#section-1'><span class='glyphicon glyphicon-home'></span>  首页</a></li>
                                  <li><a href='#section-2'><span class='glyphicon glyphicon-info-sign'></span>  资讯</a></li>
                                  <li><a href='#section-3'><span class='glyphicon glyphicon-fire'></span>  认识预警</a></li>                                  
                                  <li><a href='#section-4'><span class='glyphicon glyphicon-send'></span>  关于我们</a></li>
                                  <li><a href='#' data-toggle='modal' data-target='#login1'><span class='glyphicon glyphicon-pencil'></span>  登录/注册</a></li>";
			}
			return $data;
		}
		public function check($user){
			$sql = "SELECT * from user where username = '{$user}'";
			$result = DB::findOne($sql);
			if(isset($result)){return $result['password'];}
			else return 0;
		}
		public function msg_data($user){
			$sql = "SELECT * from reply where user = '{$user}' and statue=1";
			return DB::findAll($sql);
		}
		public function user_data($user){
			$sql = "SELECT * from user where username = '{$user}'";
			return DB::findOne($sql);
		}
		public function check_root($user){
			$sql = "SELECT * from user where username = '{$user}'";
			$result = DB::findOne($sql);
			return $result['root'];
		}
		public function update_user(){
			$arr['statue'] = 1;
			if($_POST['phone'] != "")$arr['phonenumber'] = $_POST['phone'];
			if($_POST['province'] != ""){
				$arr['province'] = $_POST['province'];
				$arr['city'] = $_POST['city'];
				$arr['county'] = $_POST['district'];
			}
			if($_POST['old_pass'] != "" && $_POST['new_pass'] != ""){
				$sql = "SELECT * from user where username = '{$_POST['user']}'";
				$result = DB::findOne($sql);
				if(md5($_POST['old_pass']) == $result['password'])$arr['password'] = md5($_POST['new_pass']);
			}
			if(count($arr) > 1)DB::update('user',$arr,"username='{$_POST['user']}'");

			$sql = "SELECT * from user where username = '{$_POST['user']}'";
			$result = DB::findOne($sql);
			$data = json_encode($result);
			echo $data;
		}
	}
?>