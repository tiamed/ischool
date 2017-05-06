<?php

namespace Students\Controller;
use Think\Controller;

class IndexController extends Controller {
    public function _initialize(){
        $login = $_SESSION['sort'];
        if($login != 1){
            $this -> error('请先登录！');
        }
    }

    public function index(){
        $this -> display();
    }

    public function poll(){
        $id = $_GET['id'];
        $this -> assign('id',$id);
        $question = M('question');
        $option = M('option');
        $answer = M('answer');
        $file_path = $_SERVER['DOCUMENT_ROOT']."/item/students/Public/Home/js/"; 
        $handle = fopen($file_path."poll.json", "w+");  
        file_put_contents($handle, "");
        if(file_exists($file_path."poll.json")){
            $poll0 = $question -> where("info_id=$id") -> select();
            $poll1 = $option -> select();
            $poll = array('0' => $poll0, '1' => $poll1); 
            fwrite($handle, json_encode($poll));
            fclose($handle);
        }
        $answerpost = $_POST['answer'];
        if(!empty($answerpost)){
            $data['id'] = $_SESSION['id'];
            $data['name'] = $_SESSION['name'];
            $data['sex'] = $_SESSION['sex'];
            $data['campus'] = $_SESSION['campus'];
            $data['class'] = $_SESSION['class'];
            $data['lphonenum'] = $_SESSION['lphonenum'];
            $data['sphonenum'] = $_SESSION['sphonenum'];
            $data['room'] = $_SESSION['room'];
            $data['num'] = $_SESSION['num'];
            for($i=0;$i<count($answerpost);$i++){
                $data['quest_id'] = $answerpost[$i][0];
                if(is_array($answerpost[$i][1])){
                    for($j=0;$j<count($answerpost[$i][1]);$j++){
                        $data['answer'] = $answerpost[$i][1][$j];
                        $answer -> data($data) -> add();
                    }
                }else{

                    $data['answer'] = $answerpost[$i][1];
                    $answer -> data($data) -> add();
                }
            }    
        }
        $this -> display();
    }

    // public function actives(){
    //     $db = M("actives");
    //     $count = $db -> count();
    //     $pagecount = 30;
    //     $page = new \Think\Page($count,$pagecount);
    //     $page -> lastSuffix = false;
    //     $show = $page -> show();
    //     $actives = $db -> order('id desc') -> limit($page -> firstRow.','.$page -> listRows) -> select();
    //     $this -> assign('page',$show);
    //     $this -> assign('actives',$actives);
    //     $this -> display();
    // }
    // 
    public function actives(){
        $num = $_SESSION['num'];
        $db = M("actives");
        $done = M('baoming as a') 
            -> join('users as c on c.num = a.stu_id') 
            -> join('actives as b on b.id = a.active_id') 
            -> where("c.num = $num") 
            -> field('b.title,b.editor,b.time,b.id') 
            -> order('b.id desc') 
            -> select();
        $all = $db 
            -> field('title,editor,time,id') 
            -> order('id desc') 
            -> select();
        $final=array();
        foreach ($all as $key => $value) {
            if(!in_array($value,$done)){
                $final[]=$value;
            }
        }
        $count = count($final);
        $pagecount = 30;
        $page = new \Think\Page($count,$pagecount);
        $page->lastSuffix = false;
        $show = $page -> show();
        $actives = array_slice($final,$page -> firstRow,$page -> listRows);
        $this -> assign('page',$show);
        $this -> assign('actives',$actives);
        $this -> display();
    }

    // public function actived(){
    //     $num = $_SESSION['num'];
    //     $count = M('baoming as a') -> join('users as c on c.num = a.stu_id') -> join('actives as b on b.id = a.active_id') -> where("c.num = $num") -> count();
    //     $pagecount = 30;
    //     $page = new \Think\Page($count,$pagecount);
    //     $page -> lastSuffix = false;
    //     $show = $page -> show();
    //     $result = M('baoming as a') -> join('users as c on c.num = a.stu_id') -> join('actives as b on b.id = a.active_id') -> where("c.num = $num") -> order('a.time desc') -> limit($page -> firstRow.','.$page -> listRows) -> select();
    //     $this -> assign('result',$result);
    //     $this -> assign('page',$show);
    //     $this -> display();
    // }
    // 
    public function actived(){
        $num = $_SESSION['num'];
        $list = M('baoming as a') 
            -> join('users as c on c.num = a.stu_id') 
            -> join('actives as b on b.id = a.active_id') 
            -> where("c.num = $num") 
            -> field('b.title,b.editor,b.time,b.id') 
            -> order('b.id desc') 
            -> select();
        $count = count($list);
        $pagecount = 30;
        $page = new \Think\Page($count,$pagecount);
        $page->lastSuffix = false;
        $show = $page -> show();
        $result = array_slice($list,$page -> firstRow,$page -> listRows);
        $this -> assign('page',$show);
        $this -> assign('result',$result);
        $this -> display();

    }

    public function los(){
        $leaveinfo = M('leaveinfo');
        $holiday = M('holiday');
        $latest = $holiday -> order('id desc') -> limit(1) -> find();
        $time = date('Y-m-d H:i:s',time());
        $register = $_POST['register'];
        $id = $latest['id'];
        $where['id'] = $id;
        $where['num'] = $_SESSION['num'];
        $count = $leaveinfo -> where($where) -> count();
        if((strtotime($time) <= strtotime($latest['start'])) || (strtotime($time) >= strtotime($latest['end']))){
            $this -> error('暂无需填写的离校统计!',U('Students/Index/leavelist'));
        }else if($count){
            $this -> error('您已提交，无法重复提交！',U('Students/Index/leavelist'));
        }else if(!empty($register)){
            $leaveinfo -> create();
            $leaveinfo -> register = $register;
            $leaveinfo -> stu_id = $_SESSION['id'];
            $leaveinfo -> name = $_SESSION['name'];
            $leaveinfo -> num = $_SESSION['num'];
            $leaveinfo -> class = $_SESSION['class'];
            $leaveinfo -> campus = $_SESSION['campus'];
            $leaveinfo -> id = $id;
            $leaveinfo -> edit_time = $time;
            $leaveinfo -> add();
        }
        $this -> assign('latest',$latest);
        $this -> display();   
    }

    public function leave(){
        $holiday = M('holiday');
        $latest = $holiday -> order('id desc') -> limit(1) -> find();
        $leave = M('leaveinfo');
        $id = $latest['id'];
        $where['id'] = $id;
        $where['num'] = $_SESSION['num'];
        $count = $leave -> where($where) -> count();
        $time = date('Y-m-d H:i:s',time());
        if((strtotime($time) <= strtotime($latest['start'])) || (strtotime($time) >= strtotime($latest['end']))){
            $this -> error('暂无需填写的离校统计!',U('Students/Index/leavelist'));
        }else if($count){
            $this -> error('您已提交，无法重复提交！',U('Students/Index/leavelist'));
        }else if(!empty($_POST)){
            $leave -> create();
            $leave -> stu_id = $_SESSION['id'];
            $leave -> name = $_SESSION['name'];
            $leave -> num = $_SESSION['num'];
            $leave -> class = $_SESSION['class'];
            $leave -> campus = $_SESSION['campus'];
            $leave -> id = $_GET['id'];
            $time = date('Y-m-d H:i:s',time());
            $leave -> edit_time = $time;
            $leave -> register = '离校';
            $info = $leave -> add();
            if($info){
                $this -> success('提交成功！',U('Students/Index/leavelist'));
            }else{
                $this -> error('提交失败！');
            }
            exit();
        }
        $this -> assign('latest',$latest);
        $this -> display();
    }

    public function leavelist(){
        $num = $_SESSION['num'];
        $count = M('holiday as a') 
            -> join('leaveinfo as b on b.id = a.id') 
            -> where("b.num = $num") 
            -> count();
        $pagecount = 30;
        $page = new \Think\Page($count,$pagecount);
        $page -> lastSuffix = false;
        $show = $page -> show();
        $list = M('holiday as a') 
            -> join('leaveinfo as b on b.id = a.id') 
            -> where("b.num = $num") 
            -> order('a.id desc') 
            -> limit($page -> firstRow.','.$page -> listRows) 
            -> select();
        $this -> assign('list',$list);
        $this -> assign('page',$show);
        $this -> display();

    }

    public function updatelos(){
        $holiday = M('holiday');
        $leaveinfo = M('leaveinfo');
        $where['id'] = $_GET['id'];
        $where['num'] = $_SESSION['num'];
        $info = $holiday -> where("id=$where[id]")-> find();
        $time = date('Y-m-d H:i:s',time());
        $register = $_POST['register'];
        $count = $leaveinfo -> where($where) -> count();
        $reg = $leaveinfo -> where($where) -> getField('register');
        if(strtotime($time) >= strtotime($info['end'])){
            $this -> error('该离校统计已过期!',U('Students/Index/leavelist'));
        }else if($reg == '已到校'){
            $this -> error('您已到校!',U('Students/Index/leavelist'));
        }else if($count == 0){
            $this -> error('请先填写该离校统计！',U('Students/Index/los'));
        }else if(!empty($register)){
            $leaveinfo -> where($where) -> setField('reason','');
            $leaveinfo -> where($where) -> setField('time',Null);
            $leaveinfo -> where($where) -> setField('way','');
            $leaveinfo -> where($where) -> setField('destination','');
            $leaveinfo -> where($where) -> setField('contacts','');
            $leaveinfo -> where($where) -> setField('telephone','');
            $leaveinfo -> where($where) -> setField('note','');
            $leaveinfo -> create();
            $leaveinfo -> where($where) -> save();//保存数据
        }
        $this -> assign('id',$where['id']);
        $this -> assign('info',$info);
        $this -> display();   
    }

    public function updateleave(){
        $holiday = M('holiday');
        $db = M('leaveinfo');
        $where['id'] = $_GET['id'];
        $where['num'] = $_SESSION['num'];
        $info = $holiday -> where("id=$where[id]")-> find();
        $time = date('Y-m-d H:i:s',time());
        $update = $db -> where($where) -> find();
        $reg = $db -> where($where) -> getField('register');
        $count = $db -> where($where) -> count();
        if(strtotime($time) >= strtotime($info['end'])){
            $this -> error('该离校统计已过期!',U('Students/Index/leavelist'));
        }else if($reg == '已到校'){
            $this -> error('您已到校!',U('Students/Index/leavelist'));
        }else if($count == 0){
            $this -> error('请先填写该离校统计！',U('Students/Index/los'));
        }else if(!empty($_POST)){
            $db -> create();
            $db -> where($where) -> register = '离校';
            if($db -> where($where) -> save()){
                $this -> success('修改成功!',U('Students/Index/leavelist'));
            }else{
                $this -> redirect('Students/Index/leavelist');
            }
            exit();
        }
        $this -> assign('id',$where['id']);
        $this -> assign('update',$update);
        $this -> assign('info',$info);
        $this -> display();
    }

    public function map(){
        $holiday = M('holiday');
        $leaveinfo = M('leaveinfo');
        $where['id'] = $_GET['id'];
        $where['num'] = $_SESSION['num'];
        $info = $holiday -> where("id=$where[id]")-> find();
        $count = $leaveinfo -> where($where) -> count();
        $register = $_POST['register'];
        $time = date('Y-m-d H:i:s',time());
        $reg = $leaveinfo -> where($where) -> getField('register');
        if(strtotime($time) >= strtotime($info['end'])){
            $this -> error('该离校统计已过期!',U('Students/Index/leavelist'));
        }else if($reg == '已到校'){
            $this -> error('您已签到!',U('Students/Index/leavelist'));
        }else if($count == 0){
             $this -> error('请先填写该离校统计！',U('Students/Index/los'));
        }else if(!empty($register)){
            $leaveinfo -> create();
            $leaveinfo -> where($where) -> register = $register;
            $leaveinfo -> save();
        }
        $this -> assign('id',$where['id']);
        $this -> assign('info',$info);
        $this -> display();
    }

    // public function infolist(){
    //     $information = M('information');
    //     $count = $information -> count();
    //     $pagecount = 30;
    //     $page = new \Think\Page($count,$pagecount);
    //     $page->lastSuffix = false;
    //     $show = $page -> show();
    //     $list = $information -> order('id desc') -> limit($page -> firstRow.','.$page -> listRows) -> select();
    //     $this -> assign('list',$list);
    //     $this -> assign('page',$show);
    //     $this -> display();
    // }
    
    public function infolist(){
        $num = $_SESSION['num'];
        $information = M('information');
        $done = M("answer as a") 
            -> join("question as b on b.id = a.quest_id") 
            -> join("information as c on c.id = b.info_id") 
            -> where("a.num=$num") 
            -> field('c.id,c.editor,c.title,c.time') 
            -> order('c.id desc') 
            -> select();
        $all = $information 
            -> field('id,title,editor,time') 
            -> order('id desc') 
            -> select();
        $final=array();
        foreach ($all as $key => $value) {
            if(!in_array($value,$done)){
                $final[]=$value;
            }
        }
        $count = count($final);
        $pagecount = 30;
        $page = new \Think\Page($count,$pagecount);
        $page->lastSuffix = false;
        $show = $page -> show();
        $list = array_slice($final,$page -> firstRow,$page -> listRows);
        $this -> assign('list',$list);
        $this -> assign('page',$show);
        $this -> display();
    }

    public function infolisted(){
        $num = $_SESSION['num'];
        $count = M("answer as a") 
            -> join("question as b on b.id = a.quest_id") 
            -> join("information as c on c.id = b.info_id") 
            -> where("a.num=$num") 
            -> field('c.id,c.editor,c.title,c.time') 
            -> group("c.id") 
            -> count();
        $pagecount = 30;
        $page = new \Think\Page($count,$pagecount);
        $page->lastSuffix = false;
        $show = $page -> show();
        $list = M("answer as a") 
            -> join("question as b on b.id = a.quest_id") 
            -> join("information as c on c.id = b.info_id") 
            -> where("a.num=$num") 
            -> field('c.id,c.editor,c.title,c.time') 
            -> group("c.id") 
            -> order('c.id desc') 
            -> limit($page -> firstRow.','.$page -> listRows) 
            -> select();
        $this -> assign('list',$list);
        $this -> assign('page',$show);
        $this -> display();
    }

    public function qaa(){
        $id = $_GET['id'];
        $information = M('information');
        $title = $information -> where("id=$id") -> field('title') -> find();
        $num = $_SESSION['num'];
        $where['a.info_id'] = $id;
        $where['c.num'] = $num;
        $count = M('question as a') 
            -> join('answer as c on c.quest_id=a.id') 
            -> field('a.content,group_concat(c.answer) as answers')
            -> group('a.content')
            -> where($where)
            -> count();
        $pagecount = 30;
        $page = new \Think\Page($count,$pagecount);
        $page->lastSuffix = false;
        $show = $page -> show();
        $list = M('question as a') 
            -> join('answer as c on c.quest_id=a.id') 
            -> field('a.content,group_concat(c.answer) as answers,a.id')
            -> group('a.content,a.id')
            -> order('a.id') 
            -> where($where)
            -> limit($page -> firstRow.','.$page -> listRows) 
            -> select();
        $this -> assign('title',$title);
        $this -> assign('page',$show);
        $this -> assign('list',$list);
        $this -> display();
    }

}