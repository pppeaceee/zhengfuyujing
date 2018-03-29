<?php
	class indexModel{
		public function yujing(){
			$sql = "select * from yj WHERE state=1 ORDER BY data_time DESC LIMIT 0,10";
			// $sql = "select * from yj WHERE state=1 ORDER BY data_time DESC";
			$data = DB::findAll($sql);
			// print_r($data);
			return $data;
		}
		public function dizheng(){
			//五条数据
			$sum = 5;
			//地震危险等级指数
			$level = 3;
			//危险排序指数
			$type = "level";
			//来源几天前的数据
			$day = -10;
			$day = $day." days";
			$time = date('Y-m-dh:d:s',strtotime($day));
			// echo $time."\n";

			//预警信息是否要参与不推荐
			// $yj_time = date('Y-m-d h:d:s',strtotime($day));
			// echo $yj_time."\n";
			// $sql = "select * from yj WHERE level = '红色' and zhuantai = '发布' and data_time >= '{$yj_time}' and state = 1 ORDER BY data_time DESC LIMIT 0,{$sum}";
			// $yj_data = DB::findAll($sql);
			// print_r($yj_data);

			$sql = "select * from dz WHERE data_time >= '{$time}' and level >= '{$level}' ORDER BY {$type} DESC LIMIT 0,{$sum}";
			$data = DB::findAll($sql);
			// foreach ($data as $key => $value) {
			// 	$data[$key]['area'] = substr($value['area'] , 0 , 15);
			// }
			// print_r($data);
			return $data;
			// echo isset($data[0])."\n";
		}
		public function merge($a1,$a2){
			$data = array_merge($a1,$a2);
			return $data;
			// print_r($data);
		}
	}
?>