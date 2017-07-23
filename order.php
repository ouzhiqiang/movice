<?php 

    session_start();

      if($_SESSION['admin']['user']==null){

          header('location:./login.php');
      }

   //导入配置文件
     require('./mod/config.php');
     require('./mod/pdo.class.php');

     $mod=new pdo1();

     //print_r($_GET);
     //print_r($_POST);
     
     $order_code=date("YmdHis").rand(0000,9999);   //订单号
     $r_id=$_GET['cid'];
     $m_id=$_GET['mid'];
     $num=@count($_POST['size']);
     
     if(@count($_POST['size'])<1){ die('没有选座位');}
     $s_code=implode(",",$_POST['size']);
     $phone=$_POST['phone'];
     $static=0;                 //下单 未购买
     $order_time=time();
     $buy_time=time();
     
     $sql1="insert into morder(order_code,r_id,m_id,num,s_code,phone,static,order_time,buy_time) value(?,?,?,?,?,?,?,?,?)";

     $dat1=array($order_code,$r_id,$m_id,$num,$s_code,$phone,$static,$order_time,$buy_time);
    
     $data=array($sql1,$dat1);
     $resu=$mod->pre($data);

     //var_dump($resu);

     if($resu[0]){
        echo "<script>alert('下单成功');location.href='./buy.php?orderid=".$resu[1]."&cid=".$r_id."';</script>";
     }else{
        echo "<script>alert('下单失败');location.href='./select.php';</script>";
     }
