<?php

namespace app\index\controller;

use think\Request;
class Notice extends Base{
    /**
     * 公告详情页
     */
    public function index(){
        // 根据公告信息
        $notice = model('Notice')->getCurrentTable();
        return $this->fetch('',[
            'notice'=>$notice,
        ]);
    }
}