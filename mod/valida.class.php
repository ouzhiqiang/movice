<?php

	/*
     $rule=array(
                  array('goods','require','不能为空'),
                  array('company','require','不能为空'),
                  array('descr','require','不能为空'),
                  array('price','required','不能为空并且大于0的整数','>0'),
                  array('state','required','不能为空并且在(1,2,3)','in (1,2,3)')，
                  array('store','required','不能为空并且大于0的整数','>0'),
                  array('num','required','不能为空并且大于0的整数','>0'),
                  array('clicknum','required','不能为空并且大于0的整数','>0')
                  )
     */             


	//自动验证字段的值

	class Valid
	{
		public $rule=array(
		                  array('goods','required','不能为空'),
		                  array('company','required','不能为空'),
		                  array('descr','required','不能为空'),
		                  array('price','number','不能为空并且大于0的整数'),
		                  array('store','number','不能为空并且大于0的整数'),
		                  array('num','number','不能为空并且大于0的整数'),
		                  array('clicknum','number','不能为空并且大于0的整数'),
		                  array('isNumber','number','验证是否是数字方法isNumber'),
		                  array('isphone','telephone','验证是否是电话方法isphone'),
		                  array('ismobile','mobile','验证是否是手机号方法ismobile'),
		                  array('isemail','email','验证是否是邮箱方法isemail'),
		                  array('iscode','postcode','验证是否是邮编方法iscode'),
		                  array('isname','7','验证是否是合法名称方法isname'),
		                  array('isnumlength','8','检查字符串长度是否符合要求'),
		                  array('isenglish','9','检查输入的是否是英文'),
		                  array('ischinese','10','检查输入的是否是中文'),
		                  array('isdate','11','检查输入日期格式'),
		                  array('istime','12','检查输入的时间格式'),
		                  array('isip','ip','检查输入的ip'),
		                  array('ismoney','14','检查输入的是否是人民币格式')
		                  );  //验证规则的数组

		public $data=array();  //要验证的数组

		public $res;          //错误信息

        public function __construct($data,$rule){
        	$this->rule=$rule;
        	$this->data=$data;
        }
		

		function act()
		{
			//var_dump($data);
			
			foreach($this->rule as $v){
			           //echo $v[1].' '.$v[0].'<br>';
			           if($v[1]=='required'){
			           	    if(!array_key_exists($v[0],$this->data) || trim($this->data[$v[0]])==""){
                                  $this->res=$v[2];
                                  return false;  
			           	    }else{

			           	    }

			           }else{
	                       //echo "dsdsf {$v[0]}";
	                       if(array_key_exists($v[0],$this->data) && $this->data[$v[0]]!=''){
			                       	switch($v[1]){
			                       		  case "user_account":
		                                        $vl=$this->user_account($this->data[$v[0]],$v[2]); 
		                                        if(!$vl){ return false;}
							                   break;

							              case "email":
		                                        $vl=$this->email($this->data[$v[0]],$v[2]); 
		                                        if(!$vl){ return false;}
							                   break;
							                   
							              case "idcode":
		                                        $vl=$this->idcode($this->data[$v[0]],$v[2]); 
		                                        if(!$vl){ return false;}
							                   break;
							                   
							              case "http":
		                                        $vl=$this->http($this->data[$v[0]],$v[2]); 
		                                        if(!$vl){ return false;}
							                   break;
							                   
							              case "qq":
		                                        $vl=$this->qq($this->data[$v[0]],$v[2]); 
		                                        if(!$vl){ return false;}
							                   break;
							                   
							              case "postcode":
		                                        $vl=$this->postcode($this->data[$v[0]],$v[2]); 
		                                        if(!$vl){ return false;}
							                   break;   
							                   
							              case "ip":
		                                        $vl=$this->ip($this->data[$v[0]],$v[2]); 
		                                        if(!$vl){ return false;}
							                   break;   
							                   
							              case "telephone":
		                                        $vl=$this->telephone($this->data[$v[0]],$v[2]); 
		                                        if(!$vl){ return false;}
							                   break;
							                   
							              case "mobile":
		                                        $vl=$this->mobile($this->data[$v[0]],$v[2]); 
		                                        if(!$vl){ return false;}
							                   break;    
							                  
							              case "en_word":
		                                        $vl=$this->en_word($this->data[$v[0]],$v[2]); 
		                                        if(!$vl){ return false;}
							                   break;    
							                   
							              case "cn_word":
		                                        $vl=$this->cn_word($this->data[$v[0]],$v[2]); 
		                                        if(!$vl){ return false;}
							                   break;
							                   
							              case "number":
		                                        $vl=$this->number($this->data[$v[0]],$v[2]); 
		                                        if(!$vl){ return false;}
							                   break;

							              case "float":
		                                        $vl=$this->float($this->data[$v[0]],$v[2]); 
		                                        if(!$vl){ return false;}
							                   break; 

                                          case "integ":
                                                $vl=$this->integ($this->data[$v[0]],$v[2]); 
                                                if(!$vl){ return false;}
                                               break;                                                                                                                         
			                       	}

	                           
	                       }
	                   }    
	                    
       
				}
				return true;
				
			

		}
    





        // 获取规则数组  
    public function get_role_name(){  
        return $this->role_name;  
    }  
  
    // 设置属性规则  
    public function set_role_name($arr){  
        $this->role_name = array_merge($this->role_name, $arr);  
    }  
  
    // 验证是否为空  
    public function required($str){  
        if(trim($str) != ""){ 
        	return true;
        }else{
        	return false;
        }  
          
    }  
  
    // 验证邮件格式  
    public function email($str,$ab){  
        if(preg_match("/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/", $str)) {return true;  
        }else{ 
            $this->res=$ab;
        	return false;}  
    }  
  
    // 验证身份证  
    public function idcode($str,$ab){  
        if(preg_match("/^\d{14}(\d{1}|\d{4}|(\d{3}[xX]))$/", $str)) {return true;  
        }else {
            $this->res=$ab;
        	return false;}  
    }  
  
    // 验证http地址  
    public function http($str,$ab){  
        if(preg_match("/[a-zA-Z]+:\/\/[^\s]*/", $str)) {return true;  
        }else {
             $this->res=$ab;
        	return false;}  
    }  
  
    //匹配QQ号(QQ号从10000开始)  
    public function qq($str,$ab){  
        if(preg_match("/^[1-9][0-9]{4,}$/", $str)) {return true;  
        }else {
            $this->res=$ab;
        	return false;}  
    }  
  
    //匹配中国邮政编码  
    public function postcode($str,$ab){  
        if(preg_match("/^[1-9]\d{5}$/", $str)) {return true;  
        }else {
            $this->res=$ab;
        	return false;}  
    }  
  
    //匹配ip地址  
    public function ip($str,$ab){  
        if(preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $str)) {return true;  
        }else {
            $this->res=$ab;
        	return false;} 
    }  
  
    // 匹配电话格式  
    public function telephone($str,$ab){  
        if(preg_match("/^\d{3}-\d{8}$|^\d{4}-\d{7}$/", $str)) {return true;  
        }else {
            $this->res=$ab;
        	return false;}  
    }  
  
    // 匹配手机格式  
    public function mobile($str,$ab){  
        if(preg_match("/^(13[0-9]|15[0-9]|18[0-9])\d{8}$/", $str)) {return true;  
        }else {
             $this->res=$ab;
        	return false;}  
    }  
  
    // 匹配26个英文字母  
    public function en_word($str,$ab){  
        if(preg_match("/^[A-Za-z]+$/", $str)) {return true;  
        }else {
             $this->res=$ab;
        	return false;}  
    }  
  
    // 匹配只有中文  
    public function cn_word($str,$ab){  
        if(preg_match("/^[\x80-\xff]+$/", $str)) {return true;  
        }else {
            $this->res=$ab;
        	return false;}  
    }  
  
    // 验证账户(字母开头，由字母数字下划线组成，4-20字节)  
    public function user_account($str,$ab){  
        if(preg_match("/^[a-zA-Z][a-zA-Z0-9_]{3,19}$/", $str)) {             
        	return true;  
        }else {
            $this->res=$ab;
        	return false; } 
    }  
  
    // 验证数字  
    public function number($str,$ab){  
        if(preg_match("/^[1-9]+$/", $str)) {return true;  
        }else {
            $this->res=$ab;
        	return false;}  
    }  

     // 验证小数  
    public function float($str,$ab){  
        if(preg_match("/^[1-9][0-9]*(\.[0-9]{2})?$/", $str)) {return true;  
        }else {
            $this->res=$ab;
        	return false;}  
    } 

     // 验证1-10的整数  
    public function integ($str,$ab){  
        if(preg_match("/^([1-9]|(10))$/", $str)) {return true;  
        }else {
            $this->res=$ab;
            return false;}  
    }   


	}