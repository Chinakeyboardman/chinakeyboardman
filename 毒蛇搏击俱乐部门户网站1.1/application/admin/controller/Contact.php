<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
class Contact extends Base{

    /**
     * 联系方式
     * 
     */
    public function index(){
        $contact = model('Contact')->get(1);
        return $this->fetch('',[
             'contact'=>$contact,
        ]);
    }
    
    /*更新联系方式*/
    public function update(){
        $data = Request::instance()->param();
        $data['update_time'] = date('Y-m-d h:i:s',time());
        $result =  model('Contact')->save($data,['id'=>intval($data['id'])]);
        if($result){
            $this->success('更新成功',url('contact/index'));
        }else{
            $this->error('更新失败');

        }
    }
}