<?php

namespace Model;
use Think\Model;

class UsersModel extends Model {
	public  function checkNamePwd($name,$pwd){
		
		$info = $this -> getByNum($name);
		
		if($info != null){
			if($info['pass']!=md5($pwd)){
				return false;
			}else{
				return $info;
			}
		}else{
			return false;
		}
	}

}