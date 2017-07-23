<?php
  
  session_start();

      if($_SESSION['admin']['user']==null){

          header('location:./login.php');
      }else{
         echo "欢迎你 ".$_SESSION['admin']['user'];
         echo "<a href='reg.php'>退出</a>";
      }
     //导入配置文件

     require('./mod/config.php');
     require('./mod/pdo.class.php');
     //require('./redis.class.php');
     $mod=new pdo1();
     //$sql="select * from movie";
     //$res=$mod->query($sql);

     //print_r($res); 
 ?>    

 <html>
       <head>
             <meta charset='utf-8'>
             <title>首页</title>
       </head>
       <body>
              <center><br><br><br>
                       <h3>今日放映</h3>
                       <hr>
                       <table border='1' cellspacing='0' >
                              <tr>
                                  <th>影片</th><th>影片名称</th><th>导演</th><th>主演</th>
                                  <th>放映信息</th><th>时长</th><th>票价</th><th>操作</th>
                              </tr>
                              <?php
                                /*
                                  $sql="select m.id,m.m_name,m.m_time,m.m_price,m.actor,m.m_director,m.content,m.picurl from movie m inner join relss r on m.id=r.m_id group by r.m_id";
                                  $res=$mod->query($sql);

                                  foreach($res as $k=>$v){
                                    echo "<tr>";
                                    echo "<td width='200'><img height='60' width='100%' src='.".$v['picurl']."'></td><td>{$v['m_name']}</td><td>{$v['m_director']}</td><td width='150'>{$v['actor']}</td>";
                                    echo "<td width='250'>".mb_substr($v['content'],0,30).".....</td><td>{$v['m_time']}</td><td>{$v['m_price']}</td><td><a href='detail.php?id={$v['id']}'>查看详情</a></td>";
                                    echo "</tr>";
                                  }
                                */
                                
                                //redis缓存数据
                                 $sql="select m.id,m.m_name,m.m_time,m.m_price,m.actor,m.m_director,m.content,m.picurl from movie m inner join relss r on m.id=r.m_id group by r.m_id"; 
                                 $data=array($sql,$sql);
                                 $res=$mod->getData($data);

                                 foreach($res as $k=>$v){
                                    echo "<tr>";
                                    echo "<td width='200'><img height='60' width='100%' src='.".$v['picurl']."'></td><td>{$v['m_name']}</td><td>{$v['m_director']}</td><td width='150'>{$v['actor']}</td>";
                                    echo "<td width='250'>".mb_substr($v['content'],0,30).".....</td><td>{$v['m_time']}</td><td>{$v['m_price']}</td><td><a href='mvinfo.php?id={$v['id']}'>查看详情</a></td>";
                                    echo "</tr>";
                                  }
                              ?>
                       </table>
              </center>
       </body>
</html>    