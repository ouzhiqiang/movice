<?php 

    session_start();

      if($_SESSION['admin']['user']==null){

          header('location:./login.php');
      }

   //导入配置文件
     require('./mod/config.php');
     require('./mod/pdo.class.php');

     $mod=new pdo1();
     
     $id=$_GET['cid']+0;
     $orderid=$_GET['orderid'];

     $list3=$mod->getredis($orderid);
     $list2=json_decode($list3);
     //var_dump($list2);

     if($list2==null){echo "<script> window.location.href='./index.php';alert('请重新选择座位！')</script>";}

     $sql="select m_name,h_id,m_time,time,start_time,end_time,m_price from relss where id='{$id}'";

     $list1=$mod->query($sql);

     $list1=array_pop($list1);

?>


<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>订单确认</title>
	<style>
          tr td:nth-child(3){text-align:right;}
          button{
          	color:white;
          	background:red;
          	
          	cursor:pointer;
          }
          a{color:white;text-decoration:none;}
	</style>

</head>
<body>
     <center>
	 <table border='0' width='800' height='300'>
	 	<tr>
	 		<td>影片名称：</td>
	 		<td><?php echo $list1['m_name'] ?></td>
	 		<td width='300'>手机号：</td>
	 		<td><?php echo $list2[5] ?></td>
	 	</tr>
	 	<tr>
	 		<td>放映厅：</td>
	 		<td><?php echo $list1['h_id'] ?></td>
	 		<td>数量：</td>
	 		<td><?php echo $list2[3] ?></td>
	 	</tr>
	 	<tr>
	 		<td>影片时长：</td>
	 		<td><?php echo $list1['m_time'] ?></td>
	 		<td>座位：</td>
	 		<td>
	 		<?php 
	 		       $lis=explode(",",$list2[4]);
	 		       $str1='';
	 		       foreach($lis as $v){
                      $str1.=$v[0].'排'.$v[2].'行    &nbsp;&nbsp;&nbsp;';
	 		       }
	 		       echo $str1; 
	 		?>
	 		</td>
	 	</tr>
	 	<tr>
	 		<td>日期：</td>
	 		<td><?php echo $list1['time'] ?></td>
	 		<td>单价：</td>
	 		<td><?php echo $list1['m_price'] ?></td>
	 	</tr>
	 	<tr>
	 		<td>时间：</td>
	 		<td><?php echo $list1['start_time'].'---'.$list1['end_time'] ?></td>
	 		<td>总计：</td>
	 		<td><?php echo $list2[3]*$list1['m_price'] ?></td>
	 	</tr>
	 </table>
	 <h3>请核对以上信息，如确认无误后，请你在30分钟之内完成付款操作</h3>
	 <button><a href="./dobuy.php?id=<?php echo $orderid; ?>">确认付款</a></button>
	 </center>
</body>
</html>