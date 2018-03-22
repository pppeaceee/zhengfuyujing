<?php
	class indexController{
		public function index(){
			// $indexModel = M("index");
			// $indexModel->index();
			$indexView = V("index");
			$indexView->index();
		}
	}
?>