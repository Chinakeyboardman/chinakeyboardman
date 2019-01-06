<?php
 
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
class Course extends Base{

    /**
     * 课程信息页面
     * @return mixed
     */
    public function index(){
        // 获取课程信息
        $course = model('Course')->getCurrentTable();
        // 获取教练信息
        $coach = model('Coach')->getCurrentTable();
        // 根据coach_id获取教练姓名
        foreach ($course as $value) {
            $value['coach'] = model('Coach')->get($value['coach_id'])['name'];
        }
        return $this->fetch('',[
             'course'=>$course,
             'coach'=>$coach,
        ]);
    }
    /*团体课*/
    public function pub(){
        // 获取团体课
        $where = [
            'status'=>1,
            'category'=>'public',
        ];
        $course = model('Course')->getByWhere($where);
        // 根据coach_id获取教练姓名
        foreach ($course as $value) {
            $value['coach'] = model('Coach')->get($value['coach_id'])['name'];
        }
        return $this->fetch('',[
             'course'=>$course,
        ]);
    }
    /*私教课*/
    public function pri(){
        // 获取私教课
        $where = [
            'status'=>1,
            'category'=>'privacy',
        ];
        $course = model('Course')->getByWhere($where);
        return $this->fetch('',[
             'course'=>$course,
        ]);
    }
    /*添加团体课*/
    public function add_pub(){
        // 获取教练
        $coach = model('Coach')->getCurrentTable();
        return $this->fetch('',[
             'coach'=>$coach,
        ]);
    }
    /*添加私教课*/
    public function add_pri(){
       // 获取教练特长
        $special = model('Special')->getCurrentTable();
        return $this->fetch('',[
             'special'=>$special,
        ]);
    }
    /**
     * 编辑团体课
     */
    public function edit_pub($id=0){
        if(intval($id)<1){
            $this->error('参数不合法');
        }
        // 获取教练信息
        $coach = model('Coach')->getCurrentTable();
        // 获取课程信息
        $course =model('Course')->get($id);
        // 判断是否有image数据
        if(empty($course['image'])){
                $course['image_null'] = true;
            }else{
                $course['image_null'] = false;
            }
        return $this->fetch('',[
            'course'=>$course,
            'coach'=>$coach,
        ]);
    }
        /**
     * 编辑私教课
     */
    public function edit_pri($id=0){
        if(intval($id)<1){
            $this->error('参数不合法');
        }
        // 获取课程信息
        $course =model('Course')->get($id);
        // 判断是否有image数据
        if(empty($course['image'])){
                $course['image_null'] = true;
            }else{
                $course['image_null'] = false;
            }
        // 获取教练特长
        $special = model('Special')->getCurrentTable();
        return $this->fetch('',[
            'course'=>$course,
            'special'=>$special,
        ]);
    }
    /*课程周表*/
    public function table(){
        // 获取课程信息
        $where = [
            'status'=>1,
            'category'=>'public',
        ];
        $course = model('Course')->getByWhere($where);
        /*获取课表信息*/
        $week = model('Week')->get(1);
        return $this->fetch('',[
             'course'=>$course,
             'week'=>$week,
        ]);
    }
    /*保存周表*/
    public function saveTable(){
        $data = Request::instance()->param();
        $data['update_time']=date('Y-m-d H:i:s',time());
        $res = model('Week')->save($data,['id'=>1]);
        if($res){
            $this->success('更新课表成功',url('course/table'));
        }else{
            $this->error('更新课表失败');
        }

    }
    /**
     * 添加课程信息
     * @return mixed
     */
    public function add(){
        // 获取教练
        $coach = model('Coach')->getCurrentTable();
        return $this->fetch('',[
             'coach'=>$coach,
        ]);
    }
    /**
     * 保存數據（课程信息）
     */
    public function save(){
        /**
         * 做下严格判断，看是否是以post方式提交的数据
         */
        if(!request()->isPost()){
            $this->error('请求失败');
        }
        // 获取post过来的数据
        $data = Request::instance()->param();
        unset($data['fileselect']);
        //在修改的时候如果有这个ID就转到update方法
        if(!empty($data['id'])){
            return $this->update($data);//这样代码就不会往下面走了
        }
        $data['create_time'] = date('Y-m-d h:i:s',time());
        $data['update_time'] = date('Y-m-d h:i:s',time());
        //把$data的数据提交给model层
        $res = model('Course')->add($data);
        $redirect=substr($data['category'],0,3);
        if($res){
            $this->success('新增成功',url('course/'.$redirect));
        }else{
            $this->error('新增失败');
        }
    }
    /**
     * 编辑课程信息
     */
    public function edit($id=0){
        if(intval($id)<1){
            $this->error('参数不合法');
        }
        // 获取教练信息
        $coach = model('Coach')->getCurrentTable();
        // 获取课程信息
        $course =model('Course')->get($id);
        // 判断是否有image数据
        if(empty($course['image'])){
                $course['image_null'] = true;
            }else{
                $course['image_null'] = false;
            }
        return $this->fetch('',[
            'course'=>$course,
            'coach'=>$coach,
        ]);

    }
    /*更新数据*/
    public function update($data){
        $redirect=substr($data['category'],0,3);
        $result =  model('Course')->save($data,['id'=>intval($data['id'])]);
        if($result){
            $this->success('更新成功',url('course/'.$redirect));
        }else{
            $this->error('更新失败');

        }
    }
}