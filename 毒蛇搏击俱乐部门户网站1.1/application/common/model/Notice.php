<?php
namespace app\common\model;

use think\Model;

class Notice extends BaseModel
{
    /*获得首页的公告信息  5个*/
    public function getNoticeFive(){
    	$where = [
            'status'=>1,
        ];
        $order = [
            'id'=>'desc',
        ];
        return $this->where($where)->order($order)->limit(7)->select();
    }
}