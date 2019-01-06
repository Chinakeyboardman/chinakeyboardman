<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
class Base extends Controller{
    public function status(){
        //获取值
        $data = Request::instance()->param();
        //利用TP5的validate机制  对id和status进行检验
        if(empty($data['id'])){
            $this->error('ID不合法');
        }
        if(!is_numeric($data['status'])){
            $this->error('status不合法');
        }
        //获取控制器
        $model = request()->controller();
        $res = model($model)->save(['status'=>$data['status']],['id'=>$data['id']]);
        if($res){
            $this->success('状态更新成功');
        }else{
            $this->error('状态更新失败');
        }
    }
}