<?php

namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {

    public function index_old(){
        $value = $_SESSION['name'];
        $sort = $_SESSION['sort'];
        if(!empty($sort)){
            if($sort == 1){
                $URL = 'Students';
            }
            else{
                $URL = 'Teachers';
            }
                echo "<div class='welcome'>欢迎您，<a href='".SITE_URL_L."{$URL}/Index/index' target='_blank'>{$value}</a></div>";
        }
        else{
            echo "<div class='landing2'><button type='submit' class='btn btn-lg btn-outline-secondary btn-load' id='log' data-toggle='modal' data-target='#login'>登录</button></div>";
        }
        $db = M("actives");
        $actives = $db -> order('id desc') -> limit(6) -> select();
        $this -> assign('actives',$actives);
        $this -> display();
    }

    public function change(){
        $sort = $_SESSION['sort'];
        if(empty($sort)){
            $this -> error('请先登录！');
        }
        $users = M("users"); 
        $num = $_SESSION['num'];      
        if(!empty($_POST)){
            $password = md5($_POST['password']);
            $password1 = md5($_POST['password1']);
            $sign = $users -> where("num=$num") -> getField('pass');
            if($password != $password1){
                echo "<script>alert('两次输入密码不匹配！');</script>";
            }else if($password == $sign){
                echo "<script>alert('请不要输入原密码！');</script>";
            }else{
                $users -> pass = $password;
                $info = $users -> where("num=$num") -> save();
                if($info){
                    if($sort == 1){
                        $this -> success('修改成功',U('Students/Index/index'));
                    }
                    if($sort == 2){
                        $this -> success('修改成功',U('Teachers/Index/index'));
                    }
                   
                }else{
                    $this -> error('修改失败');
                }
                exit();
            }
            
        }
         $this -> display();
    }

    public function index(){
        if(!empty($_POST)){
            $users = new \Model\UsersModel();
            $rst = $users -> checkNamePwd($_POST['username'],$_POST['password']);
            if($rst == false){
                echo "<script>alert('用户名或密码错误！');</script>";
            }else{
                session('num',$rst['num']);
                session('id',$rst['id']);
                session('sort',$rst['sort']);
                session('name',$rst['name']);
                session('campus',$rst['campus']);
                session('class',$rst['class']);
                session('sex',$rst['sex']);
                session('nation',$rst['nation']);
                session('birthday',$rst['birthday']);
                session('address',$rst['address']);
                session('lphonenum',$rst['lphonenum']);
                session('sphonenum',$rst['sphonenum']);
                session('room',$rst['room']);
                session('train',$rst['train']);
                session('subject',$rst['subject']);
                session('jobtitle',$rst['jobtitle']);
            }
        }
        $value = $_SESSION['name'];
        $sort = $_SESSION['sort'];

        if(!empty($sort)){
            if($sort == 1){
                $URL = 'Students';
            }
            else{
                $URL = 'Teachers';
            }
                echo "<div class='welcome2'>欢迎您，<a href='".SITE_URL_L."{$URL}/Index/index' target='_blank'>{$value}</a></div>";
        }
        else{
            echo "<div class='landing2 to-display'><button class='btn btn-lg btn-outline-secondary btn-load' id='log' data-toggle='modal' data-target='#login' value='登录' >登录</button></div>";
        }
        $db = M("actives");
        $actives = $db -> order('id desc') -> limit(3) -> select();
        $count = $db -> count();
        $pagecount = 4;
        $page = new \Think\Page($count,$pagecount);
        $page -> lastSuffix = false;
        $show = $page -> show();
        $list = $db -> order('id desc') -> limit($page -> firstRow.','.$page -> listRows) -> select();
        $this -> assign('actives',$actives);
        $this -> assign('list',$list);
        $this -> assign('page',$show);
        $this -> display();
    }

    public function infolist(){
        $sort = $_SESSION['sort'];
        if(!empty($sort)){
            if($sort == 1){
                $this -> redirect('Students/Index/infolist');
            }
            else{
                $this -> redirect('Teachers/Index/infolist');
            }
              
        }else{
            $this -> error('请先登录！');
        }
    }

    public function major(){
        $sort = $_SESSION['sort'];
        if(!empty($sort)){
            if($sort == 1){
                $this -> redirect('Students/Index/major');
            }
            else{
                $this -> redirect('Teachers/Index/majorlist');
            }
              
        }else{
            $this -> error('请先登录！');
        }
    }

    public function leavelist(){
        $sort = $_SESSION['sort'];
        if(!empty($sort)){
            if($sort == 1){
                $this -> redirect('Students/Index/leavelist');
            }
            else{
                $this -> redirect('Teachers/Index/leavelist');
            }
              
        }else{
            $this -> error('请先登录！');
        }
    }

    public function activelist(){
        $sort = $_SESSION['sort'];
        if(!empty($sort)){
            if($sort == 1){
                $this -> redirect('Students/Index/actived');
            }
            else{
                $this -> redirect('Teachers/Index/actived');
            }
              
        }else{
            $this -> error('请先登录！');
        }
    }

    public function detailed(){
        if(!empty($_POST)){
            $users = new \Model\UsersModel();
            $rst = $users -> checkNamePwd($_POST['username'],$_POST['password']);
            if($rst == false){
                echo "<script>alert('用户名或密码错误！');</script>";
            }else{
                session('num',$rst['num']);
                session('id',$rst['id']);
                session('sort',$rst['sort']);
                session('name',$rst['name']);
                session('campus',$rst['campus']);
                session('class',$rst['class']);
                session('sex',$rst['sex']);
                session('nation',$rst['nation']);
                session('birthday',$rst['birthday']);
                session('address',$rst['address']);
                session('lphonenum',$rst['lphonenum']);
                session('sphonenum',$rst['sphonenum']);
                session('room',$rst['room']);
                session('train',$rst['train']);
                session('subject',$rst['subject']);
                session('jobtitle',$rst['jobtitle']);
            }

        }
        $value = $_SESSION['name'];
        $sort = $_SESSION['sort'];
        if(!empty($sort)){
            if($sort == 1){
                $URL = 'Students';
            }
            else{
                $URL = 'Teachers';
            }
                echo "<div class='welcome2'>欢迎您，<a href='".SITE_URL_L."/{$URL}/Index/index' target='_blank'>{$value}</a></div>";
        }
        else{
            echo "<div class='landing2 to-display'><button class='btn btn-sm btn-outline-secondary btn-load' id='log' data-toggle='modal' data-target='#login'>登录</button></div>";
        }

        $id = $_GET['id'];
        $db = M("actives");
        $detailed = $db -> where("id=$id") -> find();
        $this -> assign('detailed',$detailed);
        $this -> display();

    }

    public function login(){
        if(!empty($_POST)){
            $users = new \Model\UsersModel();
            $rst = $users -> checkNamePwd($_POST['username'],$_POST['password']);
            if($rst == false){
                echo "<script>alert('用户名或密码错误！');</script>";
            }else{
                session('num',$rst['num']);
                session('id',$rst['id']);
                session('sort',$rst['sort']);
                session('name',$rst['name']);
                session('campus',$rst['campus']);
                session('class',$rst['class']);
                session('sex',$rst['sex']);
                session('nation',$rst['nation']);
                session('birthday',$rst['birthday']);
                session('address',$rst['address']);
                session('lphonenum',$rst['lphonenum']);
                session('sphonenum',$rst['sphonenum']);
                session('room',$rst['room']);
                session('train',$rst['train']);
                session('subject',$rst['subject']);
                session('jobtitle',$rst['jobtitle']);
            }

        }

    }

    public function logout(){
        session(null);
        $this -> redirect('Home/Index/index');
    }

    public function actives(){
        $value = $_SESSION['name'];
        $sort = $_SESSION['sort'];
        if(!empty($sort)){
            if($sort == 1){
                $URL = 'Students';
            }
            else{
                $URL = 'Teachers';
            }
                echo "<div class='welcome'>欢迎您，<a href='".SITE_URL_L."/{$URL}/Index/index' target='_blank'>{$value}</a></div>";
        }
        else{
            echo "<div class='landing2'><button class='btn btn-lg btn-outline-secondary btn-load' id='log' data-toggle='modal' data-target='#login'>登录</button></div>";
        }

        $db = M("actives");
        $count = $db -> count();
        $pagecount = 6;
        $page = new \Think\Page($count,$pagecount);
        $page->lastSuffix = false;
        $show = $page -> show();
        $actives = $db -> order('id desc') -> limit($page -> firstRow.','.$page -> listRows) -> select();
        $this -> assign('actives',$actives);
        $this -> assign('page',$show);
        $this -> display();
    }

    public function search(){

        $value = $_SESSION['name'];
        $sort = $_SESSION['sort'];
        if(!empty($sort)){
            if($sort == 1){
                $URL = 'Students';
            }
            else{
                $URL = 'Teachers';
            }
                echo "<div class='welcome'>欢迎您，<a href='".SITE_URL_L."/{$URL}/Index/index' target='_blank'>{$value}</a></div>";
        }
        else{
            echo "<div class='landing2'><button class='btn btn-lg btn-outline-secondary btn-load' id='log' data-toggle='modal' data-target='#login'>登录</button></div>";
        }

        $db = M("actives");
        $keyword = $_GET['keyword'];
        if(!empty($keyword)){
            $where['title|content|editor'] = array('like','%'.$keyword.'%');
        }
        $count = $db -> where($where) -> count();
        if(empty($count)){
            $this -> error('查无此活动！');
        }else{
            $pagecount = 6;
            $page = new \Think\Page($count,$pagecount);
            $page->lastSuffix = false;
            $show = $page -> show();
            $result = $db -> where($where) -> order('id desc') -> limit($page -> firstRow.','.$page -> listRows) -> select();
            $this -> assign('result',$result);
            $this -> assign('page',$show);
            $this -> display();
        }

    }

    public function apply(){
        $login = $_SESSION['sort'];
        if(empty($login)){
            $this -> error('请先登录！');
        }
        $baoming = M("baoming");
        $actives = M("actives");
        $id = $_GET['id'];
        $sum1 = $baoming -> where("active_id = $id") -> count();
        $sum = (int)$sum1;
        $limit1 = $actives -> where("id=$id") -> field('limit') -> find();
        $limit = (int)$limit1['limit'];
        $reg_time = $actives -> where("id = $id") -> find();
        $time = date('Y-m-d H:i:s',time());
        $where['active_id'] = $id;
        $where['stu_id'] = $_SESSION['num'];
        if(strtotime($time) <= strtotime($reg_time['reg_start'])){
            $this -> error('报名未开始！');
        }
        else if(strtotime($time) >= strtotime($reg_time['reg_end'])){
            $this -> error('报名已结束！');
        }
        else if($baoming -> where($where) -> count()){
            $this -> error('您已报名，不得重复报名！');
        }
        else if($sum >= $limit){
            $this -> error('名额已满！');
        }
        else{
            $baoming -> active_id = $id;
            $baoming -> stu_id = $_SESSION['num'];
            $time = date('Y-m-d H:i:s',time());
            $baoming -> time = $time;
            $baoming -> add();
            $this -> success('恭喜，报名成功！');
        }
    }
}
