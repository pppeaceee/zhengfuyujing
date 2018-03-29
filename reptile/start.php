<?php
	require_once "phpQuery/phpQuery.php";
	require_once "db_fns.php";
	require_once "DZ.php";
	require_once "tq.php";
	require_once "yj.php";
	$dz = new GetHTML_dz("http://www.ceic.ac.cn/ajax/search?page=%d&&start=&&end=&&jingdu1=73&&jingdu2=136&&weidu1=3&&weidu2=54&&height1=&&height2=&&zhenji1=&&zhenji2=&&callback=jQuery18006096551879017713_1517193281934&_=1517193679279");
	$tq = new GetHTML_tq("http://product.weather.com.cn/alarm/grepalarm_cn.php?_=1517191777205");
	$yj = new GetHTML_yj("https://www.tianqi.com/alarmnews/%d");
	while(true){
		$tq->islink();
		$yj->islink();
		$dz->islink();
		sleeo(1000);
	}
?>