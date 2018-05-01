<?php
	$db = mysqli_connect("112.74.35.246:3306","root","176409","tqyj");
    mysqli_query($db,"set names 'utf8'");
    $result = mysqli_query($db,"SELECT * FROM yj WHERE id = 1");
    var_dump($result);
?>