<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
class Coach extends Base{

    /**
     * 教练信息
     * 
     */
    public function index(){
        $coach = model('Coach')->getCurrentTable();
        return $this->fetch('',[
             'coach'=>$coach,
        ]);
    }
    /**
     * 添加教练信息
     * 
     */
    public function add(){
        $special = model('Special')->getCurrentTable();
        return $this->fetch('',[
            'special'=>$special,
        ]);
    }
    /**
     * 保存數據（添加教练）
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
        $coach = [
            'create_time'=>date('Y-m-d h:i:s',time()),
            'update_time'=>date('Y-m-d h:i:s',time()),
            'name'=>$data['name'],
            'age'=>$data['age'],
            'height'=>$data['height'],
            'weight'=>$data['weight'],
            'tel'=>$data['tel'],
            'special'=>$data['specialData'],
            'image'=>$data['image'],
        ];
        //把$data的数据提交给model层
        $res = model('Coach')->add($coach);
        if($res){
            $this->success('新增成功',url('coach/index'));
        }else{
            $this->error('新增失败');
        }
    }
    /**
     * 编辑教练信息
     */
    public function edit($id=0){
        if(intval($id)<1){
            $this->error('参数不合法');
        }
        // 根据ID获取教练信息
        $coach = model('Coach')->get($id);
        if(empty($coach['image'])){
                $coach['image_null'] = true;
            }else{
                $coach['image_null'] = false;
            }
        $coach_special = explode(',', $coach['special']);
        array_pop($coach_special);
        // 教练特长
        $special = model('Special')->getCurrentTable();
        return $this->fetch('',[
            'coach'=>$coach,
            'special'=>$special,
            'coach_special'=>$coach_special,
        ]);
    }
    /*更新教练信息*/
    public function update($data){
        $coach = [
            'name'=>$data['name'],
            'age'=>$data['age'],
            'height'=>$data['height'],
            'weight'=>$data['weight'],
            'tel'=>$data['tel'],
            'special'=>$data['specialData'],
            'image'=>$data['image'],
        ];
        $result =  model('Coach')->save($coach,['id'=>intval($data['id'])]);
        if($result){
            $this->success('更新成功',url('coach/index'));
        }else{
            $this->error('更新失败');

        }
    }
}