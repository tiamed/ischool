<?php

namespace Teachers\Controller;
use Think\Controller;
use Think\Upload;

class IndexController extends Controller {
    
    public function _initialize(){  
        $login = $_SESSION['sort'];
        if($login != 2){
            $this -> error('请先登录！','/item/students/index.php/Home/Index/login');
        }
    }

    public function index(){
        $this -> display();
    }

    public function showlist(){
        $db = M('users');
        $id = $_GET['id'];
        $where = "sort=1";
        $count = $db -> where($where) -> count();
        $pagecount = 30;
        $page = new \Think\Page($count,$pagecount);
        $page -> lastSuffix = false;
        $show = $page -> show();
        $list = $db -> where($where) -> order('num') -> limit($page -> firstRow.','.$page -> listRows) -> select();
        $this -> assign('id',$id);
        $this -> assign('list',$list);
        $this -> assign('page',$show);
        $this -> display();
    }

    public function xiugai(){
        $db = M('users');
        $id = $_GET['id'];
        $update = $db -> where("id=$id") -> find();
        $this -> assign('update',$update);
        if(!empty($_POST)){
            $db -> create();
            if($db -> where("id=$id") -> save()){
                    $this -> success('修改成功',U('Teachers/Index/showlist'));
            }else{
                    $this -> redirect('Teachers/Index/showlist');
            }
            exit();
        }
        $this -> display();
    }

    public function details(){
        $db = M('users');
        $id = $_GET['id'];
        $users = $db -> where("id=$id") -> select();
        $this -> assign('id',$id);
        $this -> assign('users',$users);
        $this -> display();
    }

    public function searchstu(){
        $db = M('users');
        $where['sort'] = 1;
        $keyword = $_GET['keyword'];
        if(!empty($keyword)){
            $where['num|name|sex|class|room|campus'] = array('like','%'.$keyword.'%');
            $count = $db -> where($where) -> count();
            if(empty($count)){
                $this -> error('查无此人！');
            }else{
                $pagecount = 30;
                $page = new \Think\Page($count,$pagecount);
                $page -> lastSuffix = false;
                $show = $page -> show();
                $result = $db -> where($where) -> order('num') -> limit($page -> firstRow.','.$page -> listRows) -> select();
                $this -> assign('result',$result);
                $this -> assign('page',$show);
        	}
        }else{
            $this -> error('请输入关键字');
        }
        $this -> display();
    }

    public function add(){
        if(!empty($_POST)){
            //处理上传的图片附件
            if($_FILES['photo']['error']<4){
                $cfg = array(
                    'exts' => array('jpg', 'gif', 'png', 'jpeg'),
                    'rootPath' => './Public/Uploads/',
                );
                $up = new \Think\Upload($cfg);
                $z = $up -> uploadOne($_FILES['photo']);
                $_POST['big_image'] = $up -> rootPath.$z['savepath'].$z['savename'];
            }
            //收集表单
            $actives = M('actives');
            $actives -> create();
            $actives -> editor = $_SESSION['name'];
            $time = date('Y-m-d H:i:s',time());
            $actives -> time = $time;
            $info = $actives -> add();
            if($info){
                $this -> success('发布成功！',U('Teachers/Index/actived'));
            }else {
                $this -> error('发布失败！');
            }
            exit();
        }
        $this -> display();
    }

    public function actived(){
        $db = M('actives');
        $where = "editor = '{$_SESSION['name']}'";
        $count = $db -> where($where) -> count();
        $pagecount = 30;
        $page = new \Think\Page($count,$pagecount);
        $page -> lastSuffix = false;
        $show = $page -> show();
        $list = $db -> where($where) -> order('id desc') -> limit($page -> firstRow.','.$page -> listRows) -> select();
        $this -> assign('list',$list);
        $this -> assign('page',$show);
        $this -> display();
    }

    public function update(){
        $actives = M('actives');
        $id = $_GET['id'];
        $update = $actives -> where("id=$id") -> find();
        $this -> assign('update',$update);
        if(!empty($_POST)){
            $id = $_GET['id'];
            $actives -> create();
            if($actives -> where("id=$id") -> save()){
                $this -> success('修改成功',U('Teachers/Index/actived'));
            }else{
                $this -> redirect('Teachers/Index/actived');
            }
            exit();
        }   
        $this -> display();

    }

    public function delete(){
        $id = $_GET['id'];
        $actives = M('actives');
        if($actives -> where("id=$id") -> delete()){
            $this -> success('删除成功',U('Teachers/Index/actived'));
        }else{
            $this -> error('删除失败');
        }
    }

    public function acshowlist(){
        $id = $_GET['id'];
        $actives = M('actives');
        $title = $actives -> where("id=$id") -> find();
        $count = M('baoming as a') 
            -> join('actives as b on b.id = a.active_id') 
            -> join('users as c on c.num = a.stu_id') 
            -> where("b.id = $id") 
            -> count(); 
        $pagecount = 30;
        $page = new \Think\Page($count,$pagecount);
        $page -> lastSuffix = false;
        $show = $page -> show();
        $users = M('baoming as a') 
            -> join('actives as b on b.id = a.active_id') 
            -> join('users as c on c.num = a.stu_id') 
            -> where("b.id = $id") 
            -> order('num') 
            -> limit($page -> firstRow.','.$page -> listRows) 
            -> select();
        $this -> assign('id',$id);
        $this -> assign('users',$users);
        $this -> assign('page',$show);
        $this -> assign('title',$title);
        $this -> display();
    }

    public function search(){
        $id = $_GET['id'];
        $this -> assign('id',$id);
        $actives = M('actives');
        $title = $actives -> where("id=$id") -> find();
        $keyword = $_GET['keyword'];
        if(!empty($keyword)){
            $where['num|class|name|sex|room|campus'] = array('like','%'.$keyword.'%');
            $count = M('baoming as a') 
                -> join('actives as b on b.id = a.active_id') 
                -> join('users as c on c.num = a.stu_id') 
                -> where("b.id = $id") 
                -> where($where) 
                -> count();
            if($count == 0){
                $this -> error('查无此人！');
            }else{
                $pagecount = 30;
                $page = new \Think\Page($count,$pagecount);
                $page -> lastSuffix = false;
                $show = $page -> show();
                $result = M('baoming as a') 
                    -> join('actives as b on b.id = a.active_id') 
                    -> join('users as c on c.num = a.stu_id') 
                    -> where("b.id = $id") 
                    -> where($where) 
                    -> order('num') 
                    -> limit($page -> firstRow.','.$page -> listRows) 
                    -> select(); 
                $this -> assign('result',$result);
                $this -> assign('page',$show);
            }
        }else{
            $this -> error('请输入关键字');
        }
        $this -> assign('title',$title);
        $this -> display(); 
    }

    public function leavelist(){
        $db = M('holiday');
        $count = $db -> count();
        $pagecount = 30;
        $page = new \Think\Page($count,$pagecount);
        $page -> lastSuffix = false;
        $show = $page -> show();
        $list = $db -> order('id desc') -> limit($page -> firstRow.','.$page -> listRows) -> select();
        $this -> assign('list',$list);
        $this -> assign('page',$show);
        $this -> display();
    }

    public function leaveshowlist(){
        $holiday = M("holiday");
        $db = M("leaveinfo");
        $id = $_GET['id'];
        $this -> assign('id',$id);
        $count = $db -> where("id=$id") -> count();
        $latest = $holiday -> where("id=$id") -> find();
        $pagecount = 30;
        $page = new \Think\Page($count,$pagecount);
        // $page -> setConfig('first','首页');
        // $page -> setConfig('prev','上一页');
        // $page -> setConfig('next','下一页');
        // $page -> setConfig('last','尾页');
        $page -> lastSuffix = false;
        $show = $page -> show();
        $list = $db -> where("id=$id") -> order('num') -> limit($page -> firstRow.','.$page -> listRows) -> select();
        $this -> assign('list',$list);
        $this -> assign('page',$show);
        $this -> assign('latest',$latest);
        $this -> display();
    }

    public function search_leave(){
        $holiday = M("holiday");
        $db = M("leaveinfo");
        $id = $_GET['id'];
        $this -> assign('id',$id);
        $latest = $holiday -> where("id=$id") -> find();
        $this -> assign('latest',$latest);
        $keyword = $_GET['keyword'];
        if(!empty($keyword)){
            $where['name|reason|class|way|destination|register'] = array('like', "%{$keyword}%");
            $this -> assign('keyword',$keyword);
            $where['id'] = $id;
            $count = $db -> where($where) -> count();
            if($count == 0){
                $this -> error('查无此人！');
            }else{
                $pagecount = 30;
                $page = new \Think\Page($count,$pagecount);
                $page->lastSuffix = false;
                $show = $page -> show();
                $result = $db -> where($where) -> order('num') -> limit($page -> firstRow.','.$page -> listRows) -> select();
                $this -> assign('result',$result);
                $this -> assign('page',$show);
            }
        }else{
            $this -> error('请输入关键字');
        }
        $this -> display();
    }

    public function update_leave(){
        $holiday = M("holiday");
        $id = $_GET['id'];
        $update = $holiday -> where("id=$id") -> find();
        if(!empty($_POST)){
            $holiday -> create();
            if($holiday -> where("id=$id") -> save()){
                    $this -> success('修改成功',U('Teachers/Index/leavelist'));
            }else{
                    $this -> redirect('Teachers/Index/leavelist');
            }
            exit();
        }
        $this -> assign('update',$update);
        $this -> display();
    }   
        
    public function delete_leave(){
        $id = $_GET['id'];
        $holiday = D("holiday");
        if($holiday -> where("id=$id") -> delete()){
            $this -> success('删除成功',U('Teachers/Index/leavelist'));
        }else{
            $this -> error('删除失败');
        }
    }
    
    public function leave(){
        if(!empty($_POST)){
            $db = M('holiday');
            $db -> create();
            $db -> name = $_SESSION['name'];
            $time = date('Y-m-d H:i:s',time());
            $db -> time = $time;
            $info = $db -> add();
            if($info){
                $this -> success('发布成功！',U('Teachers/Index/leavelist'));
            }else{
                $this -> error('发布失败！');
            }
            exit();
        }
        $this -> display();
    }

    public function download(){
        $id = $_GET['id'];
        $data = M('baoming as a') -> join('actives as b on b.id = a.active_id') -> join('users as c on c.num = a.stu_id') -> where("b.id = $id") -> select();
        $actives = M('actives') -> where("id = $id") -> find();
        $this -> assign('id',$id);
        
        // 导出Exl
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Worksheet.Drawing");
        import("Org.Util.PHPExcel.Writer.Excel2007");
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
    
        $objActSheet = $objPHPExcel->getActiveSheet();
        
        // 水平居中（位置很重要，建议在最初始位置）
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        
        $objActSheet->setCellValue('A1', '学号');
        $objActSheet->setCellValue('B1', '姓名');
        $objActSheet->setCellValue('C1', '性别');
        $objActSheet->setCellValue('D1', '民族');
        $objActSheet->setCellValue('E1', '学院');
        $objActSheet->setCellValue('F1', '行政班级');
        $objActSheet->setCellValue('G1', '出生年月');
        $objActSheet->setCellValue('H1', '家庭住址');
        $objActSheet->setCellValue('I1', '手机长号');
        $objActSheet->setCellValue('J1', '手机短号');
        $objActSheet->setCellValue('K1', '寝室号');
        $objActSheet->setCellValue('L1', '火车终点站');

        //设置个表格宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);  

        
        // 垂直居中
        $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('J')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('K')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('L')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        // 处理表数据
        foreach($data as $k => $v){
            $k +=2;
            $objActSheet->setCellValue('A'.$k, $v['num']);    
            $objActSheet->setCellValue('B'.$k, $v['name']);    
            $objActSheet->setCellValue('C'.$k, $v['sex']);    
            $objActSheet->setCellValue('D'.$k, $v['nation']);
            $objActSheet->setCellValue('E'.$k, $v['campus']);    
            $objActSheet->setCellValue('F'.$k, $v['class']);
            $objActSheet->setCellValue('G'.$k, $v['birthday']);    
            $objActSheet->setCellValue('H'.$k, $v['address']);
            $objActSheet->setCellValue('I'.$k, $v['lphonenum']);    
            $objActSheet->setCellValue('J'.$k, $v['sphonenum']);
            $objActSheet->setCellValue('K'.$k, $v['room']);    
            $objActSheet->setCellValue('L'.$k, $v['train']);
        }
        
        $fileName = '活动报名信息';
        $date = date("Y-m-d",time());
        $fileName .= "_{$actives['title']}_{$date}.xls";

        $fileName = iconv("utf-8", "gb2312", $fileName);
        //重命名表
        // $objPHPExcel->getActiveSheet()->setTitle('test');
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        // END    
    }

    public function stu_download(){
        $data = M('users') -> where("sort=1") -> select();
        
        // 导出Exl
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Worksheet.Drawing");
        import("Org.Util.PHPExcel.Writer.Excel2007");
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
    
        $objActSheet = $objPHPExcel->getActiveSheet();
        
        // 水平居中（位置很重要，建议在最初始位置）
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        
        $objActSheet->setCellValue('A1', '学号');
        $objActSheet->setCellValue('B1', '姓名');
        $objActSheet->setCellValue('C1', '性别');
        $objActSheet->setCellValue('D1', '民族');
        $objActSheet->setCellValue('E1', '学院');
        $objActSheet->setCellValue('F1', '行政班级');
        $objActSheet->setCellValue('G1', '出生年月');
        $objActSheet->setCellValue('H1', '家庭住址');
        $objActSheet->setCellValue('I1', '手机长号');
        $objActSheet->setCellValue('J1', '手机短号');
        $objActSheet->setCellValue('K1', '寝室号');
        $objActSheet->setCellValue('L1', '火车终点站');

        //设置个表格宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);  

        
        // 垂直居中
        $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('J')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('K')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('L')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        // 处理表数据
        foreach($data as $k=>$v){
            $k +=2;
            $objActSheet->setCellValue('A'.$k, $v['num']);    
            $objActSheet->setCellValue('B'.$k, $v['name']);    
            $objActSheet->setCellValue('C'.$k, $v['sex']);    
            $objActSheet->setCellValue('D'.$k, $v['nation']);
            $objActSheet->setCellValue('E'.$k, $v['campus']);    
            $objActSheet->setCellValue('F'.$k, $v['class']);
            $objActSheet->setCellValue('G'.$k, $v['birthday']);    
            $objActSheet->setCellValue('H'.$k, $v['address']);
            $objActSheet->setCellValue('I'.$k, $v['lphonenum']);    
            $objActSheet->setCellValue('J'.$k, $v['sphonenum']);
            $objActSheet->setCellValue('K'.$k, $v['room']);    
            $objActSheet->setCellValue('L'.$k, $v['train']);
        }
        
        $fileName = '学生信息';
        $date = date("Y-m-d",time());
        $fileName .= "_{$date}.xls";

        $fileName = iconv("utf-8", "gb2312", $fileName);
        //重命名表
        // $objPHPExcel->getActiveSheet()->setTitle('test');
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        // END    
    }

    public function leave_download(){
        $id = $_GET['id'];
        $this -> assign('id',$id);
        $holiday = M("holiday");
        $title = $holiday -> where("id=$id") -> find();
        $db = M("leaveinfo") -> where("id=$id") -> order('num') -> select();
        
        // 导出Exl
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Worksheet.Drawing");
        import("Org.Util.PHPExcel.Writer.Excel2007");
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
    
        $objActSheet = $objPHPExcel->getActiveSheet();
        
        // 水平居中（位置很重要，建议在最初始位置）
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        
        $objActSheet->setCellValue('A1', '学号');
        $objActSheet->setCellValue('B1', '姓名');
        $objActSheet->setCellValue('C1', '学院');
        $objActSheet->setCellValue('D1', '班级');
        $objActSheet->setCellValue('E1', '离校原因');
        $objActSheet->setCellValue('F1', '离校时间');
        $objActSheet->setCellValue('G1', '离校方式');
        $objActSheet->setCellValue('H1', '目的地');
        $objActSheet->setCellValue('I1', '紧急联系人');
        $objActSheet->setCellValue('J1', '联系电话');
        $objActSheet->setCellValue('K1', '到校情况');
        $objActSheet->setCellValue('L1', '备注');

        //设置个表格宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);

        
        // 垂直居中
        $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('J')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('K')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('L')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // 处理表数据
        foreach($db as $k => $v){
            $k +=2;
            $objActSheet->setCellValue('A'.$k, $v['num']);    
            $objActSheet->setCellValue('B'.$k, $v['name']);    
            $objActSheet->setCellValue('C'.$k, $v['campus']);    
            $objActSheet->setCellValue('D'.$k, $v['class']);
            $objActSheet->setCellValue('E'.$k, $v['reason']);    
            $objActSheet->setCellValue('F'.$k, $v['time']);
            $objActSheet->setCellValue('G'.$k, $v['way']);    
            $objActSheet->setCellValue('H'.$k, $v['destination']);
            $objActSheet->setCellValue('I'.$k, $v['contacts']);    
            $objActSheet->setCellValue('J'.$k, $v['telephone']);
            $objActSheet->setCellValue('K'.$k, $v['register']);
            $objActSheet->setCellValue('L'.$k, $v['note']); 
        }
        
        $fileName = '离返校统计';
        $date = date("Y-m-d",time());
        $fileName .= "_{$title['title']}_{$date}.xls";

        $fileName = iconv("utf-8", "gb2312", $fileName);
        //重命名表
        // $objPHPExcel->getActiveSheet()->setTitle('test');
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        // END    
    }

// --------------------------------------------------------------------
    public function form(){
        if(!empty($_POST)){
            $information = M('information');
            $information -> create();
            $information -> editor = $_SESSION['name'];
            $time = date('Y-m-d H:i:s',time());
            $information -> time = $time;
            $info = $information -> add();
            if($info){
                $this -> redirect('Teachers/Index/questionnaire',array('id' => $info));
                return $info;
            }else {
                $this -> error('发布失败！');
            }
            exit();
        }
        $this -> display();
    }

    public function questionnaire(){
        $info_id = $_GET['id'];
        $this -> assign('id',$info_id);
        if(!empty($_POST)){
            $questions = $_POST['questions'];
            $information = M('information');
            $question = M('question');
            $option = M('option');
            for($i=0;$i<count($questions);$i++){
                $question -> create();
                $data['content'] = $questions[$i]['question'];
                $data['kind'] = $questions[$i]['type'];
                $data['info_id'] = $info_id;
                $id = $question -> data($data) -> add();
                if(is_array($questions[$i]['variation'])){
                    for($j=0;$j<count($questions[$i]['variation']);$j++){
                        $data1['content'] = $questions[$i]['variation'][$j];
                        $data1['quest_id'] = $id;
                        $option -> add($data1);
                    }
                }
            }
            if($id){
                $this -> success('发布成功！',U('Teachers/Index/infolist'));
            }else{
                $this -> error('发布失败！');
            }
            exit();
        }
        $this -> display();
    }
    

    public function infolist(){
        $db = M('information');
        $count = $db -> count();
        $pagecount = 30;
        $page = new \Think\Page($count,$pagecount);
        $page -> lastSuffix = false;
        $show = $page -> show();
        $list = $db -> order('id desc') -> limit($page -> firstRow.','.$page -> listRows) -> select();
        $this -> assign('list',$list);
        $this -> assign('page',$show);
        $this -> display();
    }

    public function infoupdate(){
        $information = M("information");
        $id = $_GET['id'];
        $update = $information -> where("id=$id") -> find();
        if(!empty($_POST)){
            $information -> create();
            if($information -> where("id=$id") -> save()){
                    $this -> success('修改成功',U('Teachers/Index/infolist'));
            }else{
                    $this -> redirect('Teachers/Index/infolist');
            }
            exit();
        }
        $this -> assign('update',$update);
        $this -> display();
    }

    public function infodelete(){
        $id = $_GET['id'];
        $information = M("information");
        if($information -> where("id=$id") -> delete()){
            $this -> success('删除成功',U('Teachers/Index/infolist'));
        }else{
            $this -> error('删除失败');
        }
    }

    public function questionlist(){
        $question = M("question");
        $id = $_GET['id'];
        $count = $question -> where("info_id=$id") -> count();
        $pagecount = 30;
        $page = new \Think\Page($count,$pagecount);
        $page -> lastSuffix = false;
        $show = $page -> show();
        $list = $question -> where("info_id=$id") -> order('id') -> limit($page -> firstRow.','.$page -> listRows) -> select();
        $this -> assign('list',$list);
        $this -> assign('page',$show);
        $this -> display();
    }

    public function tiankong(){
        $id = $_GET['id'];
        $question = M('question');
        $answer = M('answer');
        $kind = $question -> where("id=$id") -> find();
        $this -> assign('id',$id);
        $this -> assign('kind',$kind);
        if($kind['kind'] == 'text'){
            $count = $answer -> where("quest_id=$id") -> count();
            $pagecount = 30;
            $page = new \Think\Page($count,$pagecount);
            $page -> lastSuffix = false;
            $show = $page -> show();
            $list = $answer -> where("quest_id=$id") -> order('num') -> limit($page -> firstRow.','.$page -> listRows) -> select();
            $this -> assign('list',$list);
            $this -> assign('page',$show);
            $this -> display();
        }else{
            $this -> redirect('Teachers/Index/chart',array('id' => $id));
        }
    }

    public function searchtk(){
        $id = $_GET['id'];
        $question = M('question');
        $answer = M('answer');
        $users = M('users');
        $kind = $question -> where("id=$id") -> find();
        
        $keyword = $_GET['keyword'];
        if(!empty($keyword)){
            $where['name|num|answer|class|sex|campus'] = array('like', "%{$keyword}%");
            $this -> assign('keyword',$keyword);
            $where['quest_id'] = $id;
            $count = $answer -> where($where) -> count();
            if($count == 0){
                $this -> error('查无此人！');
            }else{
                $pagecount = 30;
                $page = new \Think\Page($count,$pagecount);
                $page -> lastSuffix = false;
                $show = $page -> show();
                $list = $answer -> where($where) -> order('num') -> limit($page -> firstRow.','.$page -> listRows) -> select();
                $this -> assign('list',$list);
                $this -> assign('page',$show);
            }
        }else{
            $this -> error('请输入关键字');
        }
        $this -> assign('kind',$kind);
        $this -> display();
    }

    public function chart(){
        $id = $_GET['id'];
        $question = M('question');
        $answer = M('answer');
        $users = M('users');
        $option = M('option');
        $title = $question -> where("id=$id") -> find();

        $count = $answer
            -> field('group_concat(answer) as answers,num,quest_id,name,class,campus,id,sex')
            -> group('num,name,class,campus,id,sex')
            -> where("quest_id=$id")
            -> count();
        $pagecount = 30;
        $page = new \Think\Page($count,$pagecount);
        $page -> lastSuffix = false;
        $show = $page -> show();
        $outcome = $answer
            -> field('group_concat(answer) as answers,num,quest_id,name,class,campus,id,sex')
            -> group('num,name,class,campus,id,sex')
            -> where("quest_id=$id")
            -> order('id') 
            -> limit($page -> firstRow.','.$page -> listRows) 
            -> select();

        $result = M('answer')
            -> field('answer,count(answer) as count_num')
            -> group('answer')
            -> where("quest_id=$id")
            -> select();
        $limit = count($result);
        $sum = $answer -> where("quest_id=$id") -> count();
        for($i=0;$i<$limit;$i++){
            $chart[$i][0] = $result[$i]['answer'];
            $chart[$i][1] = $result[$i]['count_num']/$sum*100;
        }
        $c = json_encode($chart);
        echo "<script>var st='$c';</script>";

        $this -> assign('title',$title);
        $this -> assign('outcome',$outcome);
        $this -> assign('page',$show);
        $this -> assign('id',$id);
        $this -> display();
    }

    public function searchopt(){
        $answer = M('answer');
        $id = $_GET['id'];
        $this -> assign('id',$id);
        $question = M('question');
        $title = $question -> where("id=$id") -> find();
        $this -> assign('title',$title);
        $keyword = $_GET['keyword'];
        if(!empty($keyword)){
           $where['name|num|answer|class|sex|campus'] = array('like', "%{$keyword}%"); 
           $where['quest_id'] = $id;
           $count = $answer
            -> field('group_concat(answer) as answers,num,quest_id,name,class,campus,id,sex')
            -> group('num,name,class,campus,id,sex')
            -> where($where) 
            -> count();
           if($count == 0){
                $this -> error('查无此人！');
            }else{
                $pagecount = 30;
                $page = new \Think\Page($count,$pagecount);
                $page -> lastSuffix = false;
                $show = $page -> show();
                $list = $answer
                    -> field('group_concat(answer) as answers,num,quest_id,name,class,campus,id,sex')
                    -> group('num,name,class,campus,id,sex')
                    -> where($where) 
                    -> order('num') 
                    -> limit($page -> firstRow.','.$page -> listRows) 
                    -> select();
                $this -> assign('list',$list);
                $this -> assign('page',$show);
            }
        }else{
            $this -> error('请输入关键字');
        }

        $result = M('answer')
            -> field('answer,count(answer) as count_num')
            -> group('answer')
            -> where("quest_id=$id")
            -> select();
        $limit = count($result);
        $sum = $answer -> where("quest_id=$id") -> count();
        for($i=0;$i<$limit;$i++){
            $chart[$i][0] = $result[$i]['answer'];
            $chart[$i][1] = $result[$i]['count_num']/$sum*100;
        }
        $c = json_encode($chart);
        echo "<script>var st='$c';</script>";

        $this -> display();
    }

    public function optshowlist_download(){
        $id = $_GET['id'];
        $question = M('question');
        $title = $question -> where("id=$id") -> find();
        $answer = M('answer');
        $list = $answer
            -> field('group_concat(answer) as answers,num,quest_id,name,class,campus,id,sex,room,lphonenum,sphonenum')
            -> group('num,name,class,campus,id,sex,room,lphonenum,sphonenum')
            -> where("quest_id=$id")
            -> select();
        
        // 导出Exl
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Worksheet.Drawing");
        import("Org.Util.PHPExcel.Writer.Excel2007");
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
    
        $objActSheet = $objPHPExcel->getActiveSheet();
        
        // 水平居中（位置很重要，建议在最初始位置）
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objActSheet->setCellValue('A1', '学号');
        $objActSheet->setCellValue('B1', '姓名');
        $objActSheet->setCellValue('C1', '性别');
        $objActSheet->setCellValue('D1', '学院');
        $objActSheet->setCellValue('E1', '行政班级');
        $objActSheet->setCellValue('F1', '手机长号');
        $objActSheet->setCellValue('G1', '手机短号');
        $objActSheet->setCellValue('H1', '书院寝室');
        $objActSheet->setCellValue('I1', '回答');


        //设置个表格宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(50);

        
        // 垂直居中
        $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        // 处理表数据
        foreach($list as $k => $v){
            $k +=2;
            $objActSheet->setCellValue('A'.$k, $v['num']);    
            $objActSheet->setCellValue('B'.$k, $v['name']);    
            $objActSheet->setCellValue('C'.$k, $v['sex']);    
            $objActSheet->setCellValue('D'.$k, $v['campus']);    
            $objActSheet->setCellValue('E'.$k, $v['class']);
            $objActSheet->setCellValue('F'.$k, $v['lphonenum']);    
            $objActSheet->setCellValue('G'.$k, $v['sphonenum']);
            $objActSheet->setCellValue('H'.$k, $v['room']); 
            $objActSheet->setCellValue('I'.$k, $v['answers']);       
        }
        
        $fileName = '问卷调查统计';
        $date = date("Y-m-d",time());
        $fileName .= "_{$title['content']}_{$date}.xls";

        $fileName = iconv("utf-8", "gb2312", $fileName);
        //重命名表
        // $objPHPExcel->getActiveSheet()->setTitle('test');
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        // END
    }

    public function tiankong_download(){
        $id = $_GET['id'];
        $answer = M('answer');
        $question = M('question');
        $title = $question -> where("id=$id") -> find();
        $list = $answer -> where("quest_id=$id") -> order('num') -> select();
        // 导出Exl
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Worksheet.Drawing");
        import("Org.Util.PHPExcel.Writer.Excel2007");
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
    
        $objActSheet = $objPHPExcel->getActiveSheet();
        
        // 水平居中（位置很重要，建议在最初始位置）
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objActSheet->setCellValue('A1', '学号');
        $objActSheet->setCellValue('B1', '姓名');
        $objActSheet->setCellValue('C1', '性别');
        $objActSheet->setCellValue('D1', '学院');
        $objActSheet->setCellValue('E1', '行政班级');
        $objActSheet->setCellValue('F1', '手机长号');
        $objActSheet->setCellValue('G1', '手机短号');
        $objActSheet->setCellValue('H1', '书院寝室');
        $objActSheet->setCellValue('I1', '回答');


        //设置个表格宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);

        
        // 垂直居中
        $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        // 处理表数据
        foreach($list as $k => $v){
            $k +=2;
            $objActSheet->setCellValue('A'.$k, $v['num']);    
            $objActSheet->setCellValue('B'.$k, $v['name']);    
            $objActSheet->setCellValue('C'.$k, $v['sex']);    
            $objActSheet->setCellValue('D'.$k, $v['campus']);    
            $objActSheet->setCellValue('E'.$k, $v['class']);
            $objActSheet->setCellValue('F'.$k, $v['lphonenum']);    
            $objActSheet->setCellValue('G'.$k, $v['sphonenum']);
            $objActSheet->setCellValue('H'.$k, $v['room']);
            $objActSheet->setCellValue('I'.$k, $v['answer']);
        }
        
        $fileName = '问卷调查统计';
        $date = date("Y-m-d",time());
        $fileName .= "_{$title['content']}_{$date}.xls";

        $fileName = iconv("utf-8", "gb2312", $fileName);
        //重命名表
        // $objPHPExcel->getActiveSheet()->setTitle('test');
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        // END
    }
}

