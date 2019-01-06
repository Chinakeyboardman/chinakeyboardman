<?php
 
namespace app\admin\controller;

use think\Controller;
use think\Request;
class Special extends Base{

    /**
     * 特长页面
     * @return mixed
     */
    public function index(){
        // 获取特长信息
        $special = model('Special')->getCurrentTable();
        return $this->fetch('',[
             'special'=>$special,
        ]);
    }
    /*增加教练特长*/
    public function add(){
        return $this->fetch();
    }
    /*编辑教练特长*/
    public function edit(){
        $id = Request::instance()->param('id');
        $data = model('Special')->get($id);
        return $this->fetch('',[
            'data'=>$data,
        ]);
    }
    /*保存教练特长*/
    public function save(){
        /**
         * 做下严格判断，看是否是以post方式提交的数据
         */
        if(!request()->isPost()){
            $this->error('请求失败');
        }
        $data = Request::instance()->param();
        if(!empty($data['id'])){
            return $this->update($data);//这样代码就不会往下面走了
        }
        $data['create_time'] = date('Y-m-d h:i:s',time());
        $data['update_time'] = date('Y-m-d h:i:s',time());
        //把$data的数据提交给model层
        $res = model('Special')->add($data);
        if($res){
            $this->success('新增成功',url('special/index'));
        }else{
            $this->error('新增失败');
        }
    }
    /*更新数据*/
    public function update($data){
        $result =  model('Special')->save($data,['id'=>intval($data['id'])]);
        if($result){
            $this->success('更新成功',url('special/index'));
        }else{
            $this->error('更新失败');

        }
    }
}