<?php

namespace app\index\controller;

use think\Controller;

class Base extends Controller{
    public $city='';
    public $account='';
    public function _initialize(){
        //获取用户数据
        //获取首页分类数据
        $this->assign('user',$this->getLoginUser());
        $this->assign('controller',strtolower(request()->controller()));//获取各个控制器的名字
//        echo strtolower(request()->controller());
        $this->assign('title','毒蛇搏击俱乐部');
    }
    public function cat_tree($list, $parent_id = 0)
    {
        $temp = array();
        foreach ($list as $k => $v) {
            if ($v['parent_id'] == $parent_id) {
                $temp[$k] = $v;
                $temp[$k]['son'] = $this->cat_tree($list, $v['id']);
            }
        }
        return $temp;
    }

    /**
     * 获取session
     */
    public function getLoginUser(){
        if(!$this->account){
            $this->account = session('User','','user');
        }
        return $this->account;
    }
}