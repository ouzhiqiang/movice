<?php
    session_start();
    unset($_SESSION['admin']);

    echo "<a href='login.php'>登录</a>";

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>注册</title>
	<style>
         #container{
         	width:380px;
         	background-color:pink;
         	margin:50px auto 0px;
         	padding:5px 5px 10px;
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

         #d8{
         	 background:pink;width:100%;
         	 height:40px;
         	 text-align:center;
         }
	</style>
	<script>
            function valid(){
                var user=document.getElementById('user').value;
                var pwd=document.getElementById('pwd').value;
                var pwd1=document.getElementById('pwd1').value;
                var code=document.getElementById('code').value;
                var phone=document.getElementById('phone').value;
                var email=document.getElementById('email').value;
                
                var flg=true;
                  if(user.length==0 ||pwd.length==0 ||code.length==0 || phone.length==0 || email.length==0){
                    document.getElementById('d8').innerHTML='不能为空';
                  	return false;
                  }
                   
                  if(pwd != pwd1){
                  	document.getElementById('d8').innerHTML='两次密码不同';
                  	return false;
                  }

                  return true;
                
                
            } 
	</script>
</head>
<body>  
	   <div id='container'>
	           <center><h3>请登录</h3></center>
	   	     <form action="./mod/action.php?id=insert" method='post' onsubmit="return valid();">
	   	     	  <label>用户名：<input type="text" name='user' id='user'></label>
	   	     	  <div id='d1'></div>
	   	     	  <label>密　码：<input type="password" name='pass' id='pwd'></label>
	   	     	  <div id='d2'></div>
	   	     	  <label>确认密码：<input type="password" name='pass1' id='pwd1'></label>
	   	     	  <div id='d2'></div>
	   	     	  <label>性别：<input type="radio" name='sex' value='1' checked>男<input type="radio" name='sex' value='2'>女</label>
	   	     	  <div id='d2'></div>
	   	     	  <label>地址：<input type="text" name='address'></label>
	   	     	  <div id='d2'></div>
	   	     	  <label>邮编：<input type="text" name='code' id='code'></label>
	   	     	  <div id='d2'></div>
	   	     	  <label>手机号：<input type="text" name='phone' id='phone'></label>
	   	     	  <div id='d2'></div>
	   	     	  <label>邮箱：<input type="text" name='email' id='email'></label>
	   	     	  <div id='d8'></div>

	   	     	     <center><input type="submit" value='提交'>&nbsp;
	   	     	     <input type="reset" value='重置'></center>
	   	     </form>
	   	     <!-- <a href="../myshop1/public/code.php">tupian</a>
	   	      <a href="./mod/code.php">tupian2222</a> -->
	   </div>
</body>
</html>