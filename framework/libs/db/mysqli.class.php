<?php
	class mysql{
		public $con;
		function err($error){
			die("错误！原因：".$error);
		}
		function connect($config){
			extract($config);
			if(mysqli_connect_errno($this->con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))){
				$this->err(mysqli_connect_error());
			}
			mysqli_query($this->con, "set names ".$dbcharset);
		}
		function query($sql){
			if(!($query = mysqli_query($this->con,$sql))){
				$this->err($sql."<br>".mysqli_error($this->con));
			}else{
				return $query;
			}
		}
		function findAll($query){
			while($rs = mysqli_fetch_array($query,MYSQLI_ASSOC)){
				$list[] = $rs;
			}
			return isset($list)?$list:"";
		}
		function findOne($query){
			$rs = mysqli_fetch_array($query,MYSQLI_ASSOC);
			return $rs;
		}
		function findResult($query,$row = 0,$field = 0){
			mysqli_data_seek($query, $row);
	        $rs = mysqli_fetch_array($query,MYSQLI_ASSOC);
	        return $row[$field];
		}
		function insert($table,$arr){
			foreach($arr as $key => $value){
				$value = mysqli_real_escape_string($this->con,$value);
				$keyArr[] = '`'.$key.'`';
				$valueArr[] = '\''.$value.'\'';
			}
			$keys = implode(",",$keyArr);
			$values = implode(",",$valueArr);
			$sql = "insert into ".$table."(".$keys.")values(".$values.")";
			$this->query($sql);
			return mysqli_insert_id($this->con);
		}
		function update($table,$arr,$where){
			foreach($arr as $key => $value){
				$value = mysqli_real_escape_string($this->con,$value);
				$keyAndvalueArr[] = "`".$key."`='".$value."'";
			}
			$keyAndvalues = implode(",",$keyAndvalueArr);
			$sql = "update ".$table."set ".$keyAndvalues." where ".$where;
			$this->query($sql);
		}
		function del($table,$where){
			$sql = "delete from ".$table." where ".$where;
			$this->query($sql);
		}
	}
?>