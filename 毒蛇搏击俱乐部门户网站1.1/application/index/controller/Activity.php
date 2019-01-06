<?php

namespace app\index\controller;

use think\Request;
class Activity extends Base{
    /**
     * 活动详情页
     */
    public function index(){
        // 根据ID获取活动信息
        $id = Request::instance()->param('id');
        if(!intval($id)){
            $this->error('ID不合法');
        }
        $activity = model('Activity')->get($id);
        return $this->fetch('',[
            'activity'=>$activity,
        ]);
    }
}