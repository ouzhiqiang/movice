<?php

     //pdo连接数据库

     class pdo1{

     	public $pdo;
     	public $li;

        public	function __construct()
     	{
              $this->pdo=new PDO('mysql:host='.HOST.';dbname=movice;charset=utf8',USER,PASS);
              $this->red=new Redis();
              $this->red->connect(HOST,6379);
             
     	}

     	public function insert($data)
     	{
              $sql=$data[0];
              $this->stmt=$this->pdo->prepare($sql);

              $aa=$this->stmt->execute($data[1]);

              if($aa){return true;}else{return false;}
     	}

     	public function getSet($data)
     	{
           $user=$data[2][0];

           //$this->red->set('key',45);
           //echo $this->red->get('key');exit();

            //var_dump($this->red);
            //die();

     	  if($this->red->get('num:'.$user)<3){	
                 $sql1=$data[0];

	             $sql1=md5($sql1);
	             $list=$this->red->get($sql1);

	             $list=json_decode($list,true); 

	             if(!$list){
	             	$sql2=$data[1];
	             	$this->stmt=$this->pdo->prepare($sql2);
	                 
	             	$this->stmt->execute($data[2]);

	             	$list=$this->stmt->fetch(2);
                     
                     //var_dump($list);
                     //die();
	             	 if($list){
	             	 	  

			              $this->red->set($sql1,json_encode($list));
	             	 }else{
	             	 	  //num错误登录次数
	                      $num=$this->red->get('num:'.$user);
	                      
	                      $this->red->setex('num:'.$user,1800,$num+1);

	                      return "账号和密码错误，还有".(2-$num)."次输入机会";
	                         
	             	 }

			             	
	             }
	          return $list;   
           }else{
           	 return '登录账号和密码连续3次错误，请30分钟后试试吧！';
           }  
     	}

     //index.php查询页
      public function getData($param,$exprim=10)
      {
        $key=md5($param[0]);
            $data=$this->red->get($key);
            $data=json_decode($data,true);

            if(!$data){
                  echo '查数据库';
                  $stmt=$this->pdo->prepare($param[1]);
                   
              if(array_key_exists(2,$param)){
                $stmt->bindParam(1,$param[2]);
              }
                 $stmt->execute();

                 $data=$stmt->fetchAll(2);

              //数据写入缓存redis中
              
              $this->red->setex($key,$exprim,json_encode($data));   

            }
            return $data;
      }

      //mvinfo.php 页面的查询

       public function query($sql)
      {
         $stmt=$this->pdo->query($sql);
         $result=$stmt->fetchAll(2);
         return $result;
      }


      //订单生成，及保存到redis
        public function pre($data)
        {
          
          $this->stmt=$this->pdo->prepare($data[0]);

           $bool=$this->stmt->execute($data[1]);

           if($bool){
              $redid=$this->pdo->lastInsertId();
              $datred=json_encode($data[1]);
              $this->red->setex('order:'.$redid,1800,$datred);
              //echo $redid;

           }
           $result1=array($bool,'order:'.$redid);
          return $result1; 
        }

        //获取redis的数据

        function getredis($dat){
           return $this->red->get($dat);
        }

        //删除redis的数据
        function delredis(){

        }

        //更改数据
        function upd($id){
           $this->stmt=$this->pdo->prepare($id[0]);

           $bool=$this->stmt->execute($id[1]);
           return $bool;
        }
     }