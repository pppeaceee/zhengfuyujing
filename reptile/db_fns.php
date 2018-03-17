<?php
    function connect_db(&$db){
        $db = mysqli_connect("localhost:3306","root","","tqyj");
        mysqli_query($db,"set names 'utf8'");
    }
?>