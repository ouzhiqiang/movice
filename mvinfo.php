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

     $id=$_GET['id']+0;


     //获取对应id的影片详情

     
     $sql="select * from movie where id={$id}";
     $sql1="select * from movie where id=?";
     $data11=array($sql,$sql1,$id);
     $res=$mod->getData($data11);
     $res=array_pop($res);

     $sql2="select r.start_time,r.end_time,m.m_price,r.h_id,h.HallSeating,h.HallName,r.id from movie m  inner join relss r on m.id=r.m_id  inner join hall h on h.id=r.h_id where m.id={$id}";
     $sql21="select r.start_time,r.end_time,m.m_price,r.h_id,h.HallSeating,h.HallName,r.id from movie m  inner join relss r on m.id=r.m_id  inner join hall h on h.id=r.h_id where m.id=?";
     $data11=array($sql2,$sql21,$id);
     $val=$mod->getData($data11);

?>

<!doctype html>
<html>
      <head> 
            <title>影片详情</title>
            <meta charset='utf-8'>
      </head>
      <body>
             <center>
                     <table width='900' border='1'>
                            <tr><td colspan='2'><img height='500' width='100%' src='.<?php echo $res['picurl'] ?>'></td></tr>
                            <tr><td width='100' height='50'>影片名称：</td><td><?php echo $res['m_name'] ?></td></tr>
                            <tr><td  height='50'>影片类型：</td><td><?php echo $res['m_type'] ?></td></tr>
                            <tr><td  height='50'>影片地区：</td><td><?php echo $res['country_area'] ?></td></tr>
                            <tr><td  height='50'>影片时长：</td><td><?php echo $res['m_time'] ?></td></tr>
                            <tr><td  height='50'>影片导演：</td><td><?php echo $res['m_director'] ?></td></tr>
                            <tr><td  height='50'>影片主演：</td><td><?php echo $res['actor'] ?></td></tr>
                            <tr><td  height='50'>影片剧情：</td><td><?php echo $res['content'] ?></td></tr>
                     </table><br><br><br>

                     <h3>场次列表</h3><br>
                     <hr><br>
                     <table border='1' width='800'>
                              <tr>
                              	   <th>放映厅</th><th>开场时间</th><th>结束时间</th>
                              	   <th>票价</th><th>座位数</th><th>剩余座位数</th><th>操作</th>
                              </tr>
                              <?php
                                   foreach($val as $vv){

                                      $sql1="select group_concat(s_code) as gc from morder where r_id={$vv['id']} group by r_id";
                                      $dat1=$mod->query($sql1);
                                      $dat1=array_pop($dat1);
                                      $num=0;
                                      if($dat1!=null){
                                          $dat2=explode(',',$dat1['gc']);

                                          $num=count($dat2);
                                      }
                                      
                                      
                                   	   echo "<tr>";
                                   	   echo "<td>{$vv['HallName']}</td><td>{$vv['start_time']}</td><td>{$vv['end_time']}</td>";
                                   	   echo "<td>{$vv['m_price']}</td><td>{$vv['HallSeating']}</td><td>".($vv['HallSeating']-$num)."</td>
                                       <td><a href='select.php?id={$vv['h_id']}&mid={$id}&cid={$vv['id']}&stime={$vv['start_time']}&etime={$vv['end_time']}'>去选座位</a></td>";
                                   	   echo "</tr>";
                                   }
                              ?>
                     </table>	  
             </center>
      </body>
</html>
