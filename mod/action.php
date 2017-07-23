<?php
    
    session_start();

    require('./config.php');
    require('./pdo.class.php');
    require('./valida.class.php');
    require('./Code.class.php');

    $img=new Code();
    
    $mod=new pdo1();

   /* $_SESSION['admin']['user']='test';
	$_SESSION['admin']['flg']=1;
     die();*/

    //验证规则
    $rule=array(
		                  array('name','required','不能为空'),
		                  array('pass','required','不能为空'),
		                  array('phone','required','不能为空'),
		                  array('email','required','不能为空'),
		                  
		                  
		                  
		                  array('phone','mobile','不是合法的手机号'),
		                  array('email','email','不是合法的email'),
		                  array('code','postcode','不是合法邮编'),
		                  
		                  array('name','user_account','不是字母开头，由字母数字下划线组成，4-20字节')
		                  
		                  
		                  );  //验证规则的数组


    if($_GET['id']=='login'){

    	//验证码验证

    	//die('aaaa');

    	if(!$img->check($_POST['code'])){
				//header("Location:login.php?eno=1");
				
			    die('<script>window.location.href="../login.php";alert("验证码错误！");</script>');
			  }

		    $name=$_POST['user'];
		    $pass=$_POST['pass'];
		    // echo $name,$pass;

		    if($name!='' && $pass!=''){
		         
		         $data=array(
		             "select * from users where name='{$name}' and pass='{$pass}'",
		             "select * from users where name=? and pass=?",
		             array($name,$pass)
		         	);
		         //print_r($data);die();
		         $data=$mod->getSet($data);
		         if(is_array($data)){
		              $_SESSION['admin']['user']=$data['name'];
		              $_SESSION['admin']['flg']=1;
		              header("location:../index.php");
		         }else{
		         	echo "<script> window.location.href='../login.php';alert('".$data."')</script>";
		         }

		    }else{
		    	echo "<script> window.location.href='../login.php';alert('用户名和密码不能为空！');</script>";
		    }
    }else{
    	$name=$_POST['user'];
    	$pass=$_POST['pass'];
    	$sex=$_POST['sex'];
    	$address=$_POST['address'];
    	$code=$_POST['code'];
    	$phone=$_POST['phone'];
    	$email=$_POST['email'];
    	$addtime=time();

    	$data=array('name'=>$name,'pass'=>$pass,'sex'=>$sex,'address'=>$address,'code'=>$code,'phone'=>$phone,'email'=>$email,'addtime'=>$addtime);

    	//验证数据

    	
    	$vli=new Valid($data,$rule);
             $tval=$vli->act();
             //var_dump($_POST);
             
             if(!$tval){ echo $vli->res; die();}
         $data=array($name,$pass,$sex,$address,$code,$phone,$email,$addtime);
         $sql3="insert into users (name,pass,sex,address,code,phone,email,addtime) values(?,?,?,?,?,?,?,?)";    
         $arr=array($sql3,$data);
       
         $ff=$mod->insert($arr);

         if($ff){
         	echo "<script> window.location.href='../login.php';alert('注册成功！请登录！');</script>";
         }else{ 
         	echo "<script> window.location.href='../reg.php';alert('注册失败！');</script>";
         }

    }
