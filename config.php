<?php
    
      if($_SESSION['admin']['user']==null){

          header('location:./login.php');
      }
    //定义连接pdo 的配置文件

    define('DSN','mysql:host=localhost;dbname=movice;charset=utf8');
     define('HOST','localhost');
    define('USER','root');
    define('PWD','123');