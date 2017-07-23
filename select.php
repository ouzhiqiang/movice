<?php


    session_start();

      if($_SESSION['admin']['user']==null){

          header('location:./login.php');
      }else{
         echo "欢迎你 ".$_SESSION['admin']['user'];
      }

     //导入配置文件

     require('./mod/config.php');
     require('./mod/pdo.class.php');

     $mod=new pdo1();

     //获取时间
     $stime=$_GET['stime'];
     $etime=$_GET['etime'];
     $cid=$_GET['cid']; //场次id

     //影片id
     $mid=$_GET['mid'];
     $sql1="select * from movie where id={$mid}";
     $res=$mod->query($sql1);
     $res=array_pop($res);

     //放映厅id
     $id=$_GET['id'];
     $sql2="select * from hall where id ={$id}";
     $ha=$mod->query($sql2);
     $ha=array_pop($ha);
     //print_r($ha);
     $position=$ha['HallLayout'];
     //echo $position;
     $arr=explode(',',$position);
    // print_r($arr);

?>
<!doctype html>
<html>
       <head>
              <title>选座位</title>
              <meta charset='utf-8'>
              <script src='./Uploads/js/jquery-1.10.2.min.js'></script>
              <script>
                $(document).ready(function(){
                  $('form:first').submit(function(){
                      //验证手机号
                      var value=$('input[name="phone"]').val();

                      var pattern=/^1[345678]\d{9}$/;

                      if(value.match(pattern)==null){
                        alert('请填写正确手机号');
                        return false;

                      }

                      //验证有无选中座位
                       if($('input[name="size[]"]:checked').length==0){
                           alert('请选择座位号');
                           return false;
                       }
                  });
                 });   
              </script>
       </head>
       <body>
               <center><br><br>
                       <table border='1' width='800'>
                        <form action='order.php?cid=<?php echo $cid; ?>&mid=<?php echo $mid; ?>' method='post'>
                               <tr>
                               	   <td>影片名称：<?php echo $res['m_name'] ?></td>
                                   <td></td>
                               </tr>
                               <tr>
                               	   <td>放映厅：<?php echo $ha['HallName'] ?></td>
                                   <td>手机号：<input type='text' name='phone'></td>
                               </tr>
                               <tr>
                               	   <td>影片时长：<?php echo $res['m_time'] ?></td>
                                   <td><input type='submit' value='购买'></td>
                               </tr>
                               <tr>
                               	   <td>时间：<?php echo date('Y-m-d').' '.$stime.'-----'.$etime; ?></td>
                                   <td><a href="">可选</a><a>已售</a></td>
                               </tr>
                               
                       </table>
                       <br><hr><br>
                       <table>
                       
                           <?php 
                               foreach($arr as $k=>$v){
                               	      $k=$k+1;
                               	      $st=strlen($v);
                                        	 
		                               echo "<tr>";
		                               echo "<td>".$k."</td>";
		                               $ee=1;
		                             for($i=0;$i<$st;$i++){
		                                if($v[$i]=='_'){
                                             echo "<td>&nbsp;</td>";
		                          
		                                }else{
      		                                	$sql="select group_concat(s_code) as gc from morder where r_id={$cid} group by r_id";
      		                                	$dat=$mod->query($sql);
      		                                	$dat=array_pop($dat);
      		                                	$dat1=explode(',',$dat['gc']);
    		                                	if(in_array($k.'/'.$ee,$dat1)){
                                                     echo "<td><input type='checkbox' disabled='true'  name='size[]' value='".$k.'/'.$ee."'><span style='background-color:red'>{$ee}</span></td>";
    			                                	 $ee++;
    		                                	}else{
    			                                	 echo "<td><input type='checkbox'  name='size[]' value='".$k.'/'.$ee."'>{$ee}</td>";
    			                                	 $ee++;
    			                                } 	 
    		                            } 	
		                              	
			                           } 	              	
		                                echo "</tr>";
		                              
	                            } 
	                        ?>
	                        </form>      
                       </table>
               </center>
       </body>

</html>     
