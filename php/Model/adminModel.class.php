<?php
	class adminModel{
		public function admin(){
			$time = date('Y-m-d',strtotime('-7 days'));
			$sql = "SELECT id from view where create_time > '{$time}'";
			$data[0]['page_view'] = count(DB::findAll($sql));
			$data[0]['view_time'] = date('Y-m-d');
			// var_dump($data[0]['page_view']);
			$sql = "SELECT id from user where create_time > '{$time}'";
			$data[0]['new_user'] = count(DB::findAll($sql));
			$sql = "SELECT id from user where root=1 and root_time > '{$time}'";
			$data[0]['new_admin'] = count(DB::findAll($sql));
			$sql = "SELECT id from message where create_time > '{$time}'";
			$data[0]['new_comment'] = count(DB::findAll($sql));
			$data[0]['comment_time'] = date('Y-m-d');
			$data[0]['warn_time'] = date('Y-m-d');
			// echo "<script>console.log(".print_r($data).");</script>";
			$sql = "SELECT * from message where statue = 1 ORDER BY create_time DESC LIMIT 0,3";
			$result = DB::findAll($sql);
			$data[0]['message'] = "";
			foreach ($result as $value) {
				$data[0]['message'] .= "<div class='media'>                       
				                    <div class='media-body'>
				          				<strong>{$value['user']}: <br>{$value['content']}</strong>
				                      	<div class='text-muted smaller'>留言时间: {$value['create_time']}</div>
				                	</div>
				             	</div>";
			}
			// print_r($data['message']);
			return $data;
		}
		public function index(){
			echo "<script>window.location.href='http://localhost';</script>";
		}
		public function login(){
			if(isset($_SESSION['username']) && isset($_SESSION['password'])){
				if($pass = $this->check($_SESSION['username'])){
					if($pass == md5($_SESSION['password'])){
						// echo "true";
						//自动登录
						return 1;
					}else{
						return 0;
					}
				}else return 0;
			}else{
				return 0;
			}
		}
		public function check($user){
			$sql = "SELECT * from user where username = '{$user}' and root = 1";
			$result = DB::findOne($sql);
			if(isset($result)){return $result['password'];}
			else return 0;
		}
		public function warn_data(){
			for($i = -11;$i <= 0;$i++){
				$month = $i." month";
				$month_e = ($i+1)." month";
				$date_s = Date("Y-m",strtotime($month));
				$date_e = Date("Y-m",strtotime($month_e));
				$sql = "SELECT id from yj where data_time >= '{$date_s}' and data_time < '{$date_e}'";
				$sum = count(DB::findAll($sql));
				$data[Date("n",strtotime($month))."月"] = $sum;
			}
			$data = json_encode($data);
			echo $data;
		}
		public function user_data(){
			for($i = -6;$i <= 0; $i++){
				$day_s = $i." days";
				$day_e = ($i+1)." days";
				$date_s = Date("Y-m-d",strtotime($day_s));
				$date_e = Date("Y-m-d",strtotime($day_e));
				$sql = "SELECT id from view where create_time >= '{$date_s}' and create_time < '{$date_e}'";
				$sum = count(DB::findAll($sql));
				$data[Date("n.j",strtotime($day_s))] = $sum;
			}
			$data = json_encode($data);
			echo $data;
		}
		public function usercommand(){
			$sql = "SELECT * from user where root = 0 and statue = 1 ORDER BY create_time DESC";
			$result = DB::findAll($sql);
			$data[0]['userdata'] = "";
			foreach($result as $value){
				$data[0]['userdata'] .= "<tr>
			              <td>{$value['username']}</td>
			              <td>{$value['province']}{$value['city']}{$value['county']}</td>
			              <td>{$value['phonenumber']}</td>
			              <td>{$value['password']}</td>
			              <td>{$value['create_time']}</td>
			              <td><a href='#' onclick='del_user({$value['id']});'>删除帐号</a>/<a href='#' onclick='update_admin({$value['id']});'>升为管理员</a></td>
			            </tr>";
			}
			$sql = "SELECT * from user where statue = 0 ORDER BY create_time DESC";
			$result = DB::findAll($sql);
			$data[0]['delete_userdata'] = "";
			foreach($result as $value){
				$data[0]['delete_userdata'] .= "<tr>
			              <td>{$value['username']}</td>
			              <td>{$value['province']}{$value['city']}{$value['county']}</td>
			              <td>{$value['phonenumber']}</td>
			              <td>{$value['password']}</td>
			              <td>{$value['create_time']}</td>
			              <td><a href='#' onclick='act_user({$value['id']});'>激活帐号</a></td>
			            </tr>";
			}
			$data[0]['update_time'] = date('Y-m-d');
			return $data;
		}
		public function update_admin(){
			$time = date('Y-m-d');
			$arr['root'] = 1;
			$arr['root_time'] = $time;
			DB::update('user',$arr,"id={$_POST['id']}");
			$data = $this->usercommand();
			$data = json_encode($data);
			echo $data;
		}
		public function del_user(){
			$arr['statue'] = 0;
			DB::update('user',$arr,"id={$_POST['id']}");
			$data = $this->usercommand();
			$data = json_encode($data);
			echo $data;
		}
		public function act_user(){
			$arr['statue'] = 1;
			DB::update('user',$arr,"id={$_POST['id']}");
			$data = $this->usercommand();
			$data = json_encode($data);
			echo $data;
		}
		public function commander(){
			$sql = "SELECT * from user where statue = 1 and root = 1 ORDER BY root_time DESC";
			$result = DB::findAll($sql);
			$data[0]['admin'] = "";
			foreach($result as $value){
				$data[0]['admin'] .= "<tr>
					                <td>{$value['username']}</td>
					                <td>{$value['province']}{$value['city']}{$value['county']}</td>
					                <td>{$value['phonenumber']}</td>
					                <td>{$value['root_time']}</td>
					                <td>无</td>
								</tr>";
			}
			$data[0]['update_time'] = date('Y-m-d');
			return $data;
		}
		public function note(){
			$sql = "SELECT * from message where statue = 1 ORDER BY create_time DESC";
			$result = DB::findAll($sql);
			$data[0]['note'] = "";
			foreach($result as $value){
				$data[0]['note'] .= "<tr>
                        <td>{$value['user']}</td>
                        <td>{$value['content']}</td>
                        <td>{$value['create_time']}</td>
                        <td><a href='#' onclick='delnote({$value['id']})'>删除</a></td>
                      </tr>";
			}
			$data[0]['update_time'] = date('Y-m-d');
			return $data;
		}
		public function del_note(){
			$arr['statue'] = 0;
			DB::update('message',$arr,"id={$_POST['id']}");
			$data = $this->note();
			$data = json_encode($data);
			echo $data;
		}
		public function logout(){
			unset($_SESSION['username']);
			unset($_SESSION['password']);
			echo "<script>window.location.href='http://localhost';</script>";
		}
	}
?>