<?php
 
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
class Activity extends Base{

    /**
     * 活动信息页面
     * @return mixed
     */
    public function index(){
        // 获取活动信息
        $activity = model('Activity')->getCurrentTable();
        return $this->fetch('',[
             'activity'=>$activity,
        ]);
    }
    /**
     * 添加活动信息
     * @return mixed
     */
    public function add(){
        return $this->fetch('',[
        ]);
    }
    /**
     * 保存數據（活动信息）
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
        $res = model('Activity')->add($data);
        if($res){
            $this->success('新增成功',url('activity/index'));
        }else{
            $this->error('新增失败');
        }
    }
    /**
     * 编辑活动信息
     */
    public function edit($id=0){
        if(intval($id)<1){
            $this->error('参数不合法');
        }
        // 获取活动信息
        $activity = model('Activity')->get($id);
        // 判断是否有image数据
        if(empty($activity['image'])){
                $activity['image_null'] = true;
            }else{
                $activity['image_null'] = false;
            }
        return $this->fetch('',[
            'activity'=>$activity,
        ]);

    }
    /*更新数据*/
    public function update($data){
        $data['update_time'] = date('Y-m-d h:i:s',time());
        $result =  model('Activity')->save($data,['id'=>intval($data['id'])]);
        if($result){
            $this->success('更新成功',url('activity/index'));
        }else{
            $this->error('更新失败');

        }
    }
}