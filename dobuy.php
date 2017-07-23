<?php
    
    session_start();

      if($_SESSION['admin']['user']==null){

          header('location:./login.php');
      }

   //导入配置文件
     require('./mod/config.php');
     require('./mod/pdo.class.php');

     $mod=new pdo1();



   $id=$_GET['id'];

   $id=substr($id,6)+0;
   //var_dump($id);
   
   /*$data=$mod->getredis($id);   

   $data=json_decode($data);*/

   //var_dump($id);
   //var_dump($data);


   //修改订单的状态
   $sql="update morder set static=1 where id=?";
   $id1=array($id);
   $data=array($sql,$id1);
   $res=$mod->upd($data); 

   if($res){
     echo "<script>
            var num=5;
            var timer=setInterval(function(){
                 if(num==0){
                    clearInterval(timer);
                    window.location.href='./index.php';
                 }else{
                     
                       document.write('<p>付款成功，请到影厅后，根据手机订单号取票后观影。<span>'+num+'<span>秒后返回首页</p>');

                     num--;
                 }
            }, 1000);
           </script>";
   }else{
     echo "";
   }