<?php
	class adminView{
		public function index($data){
			VIEW::display_var("templet/index.html",$data);
		}
		public function usercommand($data){
			VIEW::display_var("templet/usercommand.html",$data);
		}
		public function commander($data){
			VIEW::display_var("templet/commander.html",$data);
		}
		public function note($data){
			VIEW::display_var("templet/note.html",$data);
		}
	}
?>