<?php
	class indexView{
		public function index($data){
			VIEW::display_var('templet/zheng.html',$data);
		}
	}
?>