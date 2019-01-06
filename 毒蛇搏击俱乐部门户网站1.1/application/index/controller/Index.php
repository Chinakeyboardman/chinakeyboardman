<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
class Index extends Base
{
    /*首页*/
    public function index()
    {
        //首页视频链接
        $home_video = model('Video')->get(1)['video'];
        // 课程信息
        $course = model('Course')->getCurrentTable();
        // 私教课
        $privacy_where = [
            'status'=>1,
            'category'=>'privacy',
        ];
        $privacy_course = model('Course')->getByWhere($privacy_where);
        // 团体课
        $public_where = [
            'status'=>1,
            'category'=>'public',
        ];
        $public_course = model('Course')->getByWhere($public_where);
        // 教练信息
        $coach = model('Coach')->getCurrentTable();
        // 公告信息
        $notice = model('Notice')->getNoticeFive();
        // 活动信息
        $activity = model('Activity')->getCurrentTable();
        // 课表信息
        $week = model('Week')->get(1);
        // 健身器材信息
        $equipment = model('Equipment')->getCurrentTable();
        // 单次服务信息
        $single = model('Single')->getCurrentTable();
        // 会员卡信息
        $card = model('Card')->getCurrentTable();
        // p($activity);die;
        // gallery
        $gallery = model('Gallery')->get(1)['gallery'];
        if(substr_count($gallery,'|') >12){
            $gallery = substr($gallery, 0,$this->newstripos($gallery,'|',13));
        }
        if(substr($gallery,0,1) == '|'){
            $gallery = substr_replace($gallery,"",0,1);
         }
        $gallery_many = explode('|', $gallery);
        if(empty($gallery)){
            $file_many_null = true;
        }else{
            $file_many_null = false;
        }
        return $this->fetch('',[
            'home_video'=>$home_video,
            'course'=>$course,
            'coach'=>$coach,
            'notice'=>$notice,
            'activity'=>$activity,
            'week'=>$week,
            'privacy_course'=>$privacy_course,
            'public_course'=>$public_course,
            'equipment'=>$equipment,
            'single'=>$single,
            'card'=>$card,
            'gallery_many'=>$gallery_many,
            'file_many_null'=>$file_many_null,
            'file_many_saveurl'=>model('Gallery')->get(1)['gallery'],

        ]);
    }
    /*查询某个字符在第几个出现的下标*/
    public function newstripos($str, $find, $count, $offset=0)
    {
    $pos = stripos($str, $find, $offset);
    $count--;
    if ($count > 0 && $pos !== FALSE)
    {
    $pos = $this->newstripos($str, $find ,$count, $pos+1);
    }
    return $pos;
    }
    // 画廊
    public function gallery(){
        $galleries = model('Gallery')->get(1)['gallery'];
        if(substr($galleries,0,1) == '|'){
            $galleries = substr_replace($galleries,"",0,1);
         }
        $galleries_array = explode('|', $galleries);
        return $this->fetch('',[
            'galleries_array'=>$galleries_array,
        ]);
    }
    /*查询用户信息*/
    public function info(){
        $id = Request::instance()->param('id');
        // 根据ID获取用户信息
        $userinfo = model('User')->get($id);
        // 判断是否有图片
        if(empty($userinfo['image'])){
            $userinfo['image_null'] = true;
        }else{
            $userinfo['image_null'] = false;
        }
        // 当前用户买的团体课
        $where = [
            'status'=>1,
            'user_id'=>$id,
            'category'=>'public',
        ];
        $order = model('Order')->getByWhere($where);
        foreach ($order as $value) {
            $value['order_name'] = model('Course')->get($value['course_id'])['name'];
            $value['start_time'] = model('Course')->get($value['course_id'])['start_time'];
            $value['end_time'] = model('Course')->get($value['course_id'])['end_time'];
            $coach_id = model('Course')->get($value['course_id'])['coach_id'];
            $value['coach'] = model('Coach')->get($coach_id)['name'];
        }
        // 当前用户购买的私教课
        $yuyue_where = [
            'status'=>1,
            'user_id'=>$id,
            'category'=>'privacy',
        ];
        $yuyue = model('Order')->getByWhere($yuyue_where);
        foreach ($yuyue as $value) {
            $value['course_name'] = model('Course')->get($value['course_id'])['name'];
        }
        // 当前用户购买的健身器材
        $equip_where = [
            'status'=>1,
            'user_id'=>$id,
            'category'=>'equipment',
        ];
        $equipment = model('Order')->getByWhere($equip_where);
        foreach ($equipment as $value) {
            $value['equipment_name'] = model('Equipment')->get($value['course_id'])['name'];
        }
        // 当前用户的单次服务
        $single_where = [
            'status'=>1,
            'user_id'=>$id,
            'category'=>'single',
        ];
        $single = model('Order')->getByWhere($single_where);
        foreach ($single as $value) {
            $value['single_name'] = model('Single')->get($value['course_id'])['title'];
            $value['participate_time'] = model('Single')->get($value['course_id'])['participate_time'];
        }
        // 当前用户的会员卡
        $card_where = [
            'status'=>1,
            'user_id'=>$id,
            'category'=>'card',
        ];
        $card = model('Order')->getByWhere($card_where);
        foreach ($card as $value) {
            $value['card_name'] = model('Card')->get($value['course_id'])['name'];
        }
        // 课表信息
        $week = model('Week')->get(1);
        return $this->fetch('',[
            'userinfo'=>$userinfo,
            'order'=>$order,
            'yuyue'=>$yuyue,
            'equipment'=>$equipment,
            'single'=>$single,
            'card'=>$card,
            'week'=>$week,
        ]);
    }
    /*更新用户信息*/
    public function updateinfo(){
        if(!request()->isPost()){
            $this->error('请求失败');
        }
        $data = Request::instance()->param();
        $data['code']=mt_rand(100,10000);
        $data['password']=md5($data['password']. $data['code']);
        unset($data['fileselect']);
        $data['update_time'] = date('Y-m-d h:i:s',time());
        $result =  model('User')->save($data,['id'=>intval($data['id'])]);
        if($result){
            $this->success('更新成功');
        }else{
            $this->error('更新失败');
        }
    }
    /*更新前端小分享图片的数据*/
    public function saveImages(){
        if(!request()->isPost()){
            $this->error('请求失败');
        }
        $data = Request::instance()->param('gallery');
        $result =  Db::table('js_gallery')->where('id',1)->setField('gallery', $data);
        // $result =  model('Gallery')->save($data,['id'=>1]);
        /*if($result){
            $this->success('更新成功');
        }else{
            $this->error('更新失败');
        }*/
    }
    //接收前台文件，
    public function addExcel()
    {    
        $dir=dirname(__FILE__);                       //获取当前脚本的绝对路径
        $dir=str_replace("//","/",$dir)."/";

        $filename='uploadFile.xls'; //可以定义一个上传后的文件名称
        $result=move_uploaded_file($_FILES['upload']['tmp_name'],$dir.$filename);//假如上传到当前目录下
        if($result)  //如果上传文件成功，就执行导入excel操作
        {
        require_once 'phpExcelReader/Excel/reader.php';
        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('utf-8');//设置在页面中输出的编码方式,而不是utf8

        //该方法会自动判断上传的文件格式，不符合要求会显示错误提示信息(错误提示信息在该方法内部)。
        $data->read("$filename");  //读取上传到当前目录下名叫$filename的文件

        error_reporting(E_ALL ^ E_NOTICE);
        //如果excel表带标题，则从$i=2开始，去掉excel表中的标题部分(要将$i<=改为$i<否则会插入一条多余的空数据)
        for ($i = 2; $i < $data->sheets[0]['numRows']; $i++)
        {
        $sql = "INSERT INTO user (stuid,class,name,sex,classNum,tel,addr,remark) VALUES('".
        $data->sheets[0]['cells'][$i][1]."','".    //学号
        $data->sheets[0]['cells'][$i][2]."','".    //班级
        $data->sheets[0]['cells'][$i][3]."','".    //姓名
        $data->sheets[0]['cells'][$i][4]."','".    //性别
        $data->sheets[0]['cells'][$i][5]."','".    //班内序号
        $data->sheets[0]['cells'][$i][6]."','".    //联系电话
        $data->sheets[0]['cells'][$i][7]."','".    //联系地址
        $data->sheets[0]['cells'][$i][8]."')";     //附注

        $db->query($sql);
        $insert_info.= " $sql</br>/n";          //可以用来显示数据插入的信息

        }
        $totalNums=$data->sheets[0]['numRows']-2;//求出导入的总数据条数(这里是减去2，才会得到去除标题后的总数据)
        //echo "导入成功！";
        unlink("$filename");                             //删除上传的excel文件

        }
        else
        {
        $errmsg="上传失败";
        }

}
}