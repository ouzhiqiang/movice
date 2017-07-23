<?php
    session_start();
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>登录</title>
	<style>
         #container{
         	width:300px;padding:5px;
         	background-color:pink;
         	margin:100px auto;
         	
         }

         #d1,#d2,#d3{
         	width:160px;height:35px;
         	
         	margin-left:89px;
         }

         label{
         	margin-left:25px;
         }
         h3{
         	margin:15px auto;
         }

         img{
         	margin-top:20px;
         	margin-left:90px;
         }
	</style>
   <script src='./Uploads/js/jquery-1.10.2.min.js'></script>
   <script>
       $(document).ready(function(){
              //console.log('aaa');
              var flg=0;
         $('input[name="user"]').blur(function(){
               

              //ajax查询服务器获取用户名是否唯一
                var name=$(this).val();
                var that=$(this);
                var oldname=$(this).data('u');

                if(oldname!=name){
                  $.get(
                      './ajax/username.php',
                      {unam:name},
                      function(data){
                        that.data('u',name);
                        if(data==1){
                           that.css({'border':'2px solid red'});
                           $("#d1").children().remove();
                          $("#d1").html('<span style="color:red">用户名不能用</span>');
                           flg=0;
                        }else{
                            that.css({'border':'2px solid green'});
                            $("#d1").children().remove();
                         // $("#d1").html('<span style="color:green">用户名可以用</span>');
                          flg=1;
                        }
                      },'json'
                     );
                }
         });


      //密码验证

       $('input[name="pass"]').blur(function(){
             var pass=$(this).val();
          //alert(pass.length==0);
             if(pass.length==0){
               flg=0;
               $("#d2").children().remove();
               $(this).css('border','1px solid red')
               $("#d2").html('<span style="color:red">密码不能为空</span>');
             }else{
               flg=1;
               $("#d2").children().remove();
               $(this).css('border','2px solid green');
             }

       });


       //验证码判断
         /*$('input[name="code"]').blur(function(){

         });*/

               

          //当表单提交时触发
          $("form:first").submit(function(){
                // var name=$('input[name="user"]').val();
                //alert(flg);
                if(flg==1){
                  return true;
                }else{
                  return false;
                }
                 
          });
       });
   </script>
</head>
<body>  
	   <div id='container'>
	           <center><h3>请登录</h3></center>
	   	     <form action="./mod/action.php?id=login" method='post'>
	   	     	  <label>用户名：<input type="text" name='user'></label>
	   	     	  <div id='d1'></div>
	   	     	  <label>密　码：<input type="password" name='pass'></label>
	   	     	  <div id='d2'></div>
	   	     	  <label>验证码：<input type="text" name='code'><img src="./mod/Code.class.php?b=3" onclick="this.src='./mod/Code.class.php?b=3&id='+Math.random()"></label>
	   	     	  <div id='d3'></div>
	   	     	     <center><input type="submit" value='提交'>&nbsp;
	   	     	     <input type="reset" value='重置'></center>
	   	     </form>
           <a href='./reg.php'>注册</a>
	   	      <!-- <a href="../myshop1/public/code.php">tupian</a>
	   	      <a href="./mod/code.php">tupian2222</a>  -->
	   </div>
</body>
</html>