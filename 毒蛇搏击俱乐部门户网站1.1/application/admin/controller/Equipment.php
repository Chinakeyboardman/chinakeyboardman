<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
class Equipment extends Base{

    /**
     * 健身器材信息
     * 
     */
    public function index(){
        $equipment = model('Equipment')->getCurrentTable();
        return $this->fetch('',[
             'equipment'=>$equipment,
        ]);
    }
    /**
     * 添加健身器材信息
     * 
     */
    public function add(){
        return $this->fetch('',[
        ]);
    }
    /**
     * 保存數據（添加健身器材）
     */
    public function save(){
        /**
         * 做下严格判断，看是否是以post方式提交的数据
         */
        if(!request()->isPost()){
            $this->error('请求失败');
        }
        $data = Request::instance()->param();
        unset($data['fileselect']);
        //在修改的时候如果有这个ID就转到update方法
        if(!empty($data['id'])){
            return $this->update($data);//这样代码就不会往下面走了
        }
        $data['create_time']=date('Y-m-d H:i:s',time());
        $data['update_time']=date('Y-m-d H:i:s',time());
        //把$data的数据提交给model层
        $res = model('Equipment')->add($data);
        if($res){
            $this->success('新增成功',url('equipment/index'));
        }else{
            $this->error('新增失败');
        }
    }
    /**
     * 编辑健身器材信息
     */
    public function edit($id=0){
        if(intval($id)<1){
            $this->error('参数不合法');
        }
        // 根据ID获取健身器材信息
        $equipment = model('Equipment')->get($id);
        if(empty($equipment['image'])){
                $equipment['image_null'] = true;
            }else{
                $equipment['image_null'] = false;
            }
        return $this->fetch('',[
            'equipment'=>$equipment,
        ]);
    }
    /*更新健身器材信息*/
    public function update($data){
        $data['update_time']=date('Y-m-d H:i:s',time());
        $result =  model('Equipment')->save($data,['id'=>intval($data['id'])]);
        if($result){
            $this->success('更新成功',url('equipment/index'));
        }else{
            $this->error('更新失败');

        }
    }
}