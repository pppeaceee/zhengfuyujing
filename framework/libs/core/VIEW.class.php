<?php
	class VIEW{
		public static $view;
		public static function init($viewtype,$config){
			self::$view = new $viewtype;
			// foreach($config as $key => $value){
			// 	self::$view->$key = $value;
			// }
		}
		public static function assign($data){
			foreach($data as $key => $value){
				self::$view->assign($key,$value);
			}
		}
		public static function display($data){
			self::$view->display($data);
		}
		public static function display_var($url,$data){
			self::$view->display_var($url,$data);
		}
	}
?>