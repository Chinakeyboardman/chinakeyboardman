<?php
 
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
class Order extends Base{

    /**
     * 团课订单信息页面
     * @return mixed
     */
    public function index(){
        // 获取团课订单信息
        $public_where = [
            'status'=>1,
            'category'=>'public',
        ];
        $order = model('Order')->getByWhere($public_where);
        foreach ($order as $value) {
            $value['username'] = model('User')->get($value['user_id'])['username'];
            $value['coursename'] = model('Course')->get($value['course_id'])['name'];
            $value['coach_id'] = model('Course')->get($value['course_id'])['coach_id'];
            $value['coachname'] = model('Coach')->get($value['coach_id'])['name'];
        }
        return $this->fetch('',[
             'order'=>$order,
        ]);
    }
    /**
     * 私教课订单信息页面
     * @return mixed
     */
    public function privacy(){
        // 获取私教课订单信息
        $privacy_where = [
            'status'=>1,
            'category'=>'privacy',
        ];
        $order = model('Order')->getByWhere($privacy_where);

        foreach ($order as $value) {
            $value['username'] = model('User')->get($value['user_id'])['username'];
            $value['coursename'] = model('Course')->get($value['course_id'])['name'];
        }
        return $this->fetch('',[
             'order'=>$order,
        ]);
    }
    /**
     * 单次服务订单信息页面
     * @return mixed
     */
    public function single(){
        // 获单次服务订单信息
        $public_where = [
            'status'=>1,
            'category'=>'single',
        ];
        $order = model('Order')->getByWhere($public_where);
        
        foreach ($order as $value) {
            $value['username'] = model('User')->get($value['user_id'])['username'];
            $value['coursename'] = model('Single')->get($value['course_id'])['title'];
            $value['participate_time'] = model('Single')->get($value['course_id'])['participate_time'];
        }
        return $this->fetch('',[
             'order'=>$order,
        ]);
    }
    /**
     * 会员卡订单信息页面
     * @return mixed
     */
    public function card(){
        // 获取会员卡订单信息
        $public_where = [
            'status'=>1,
            'category'=>'card',
        ];
        $order = model('Order')->getByWhere($public_where);
        foreach ($order as $value) {
            $value['username'] = model('User')->get($value['user_id'])['username'];
            $value['coursename'] = model('Card')->get($value['course_id'])['name'];
        }
        return $this->fetch('',[
             'order'=>$order,
        ]);
    }
    /**
     * 健身器材订单信息页面
     * @return mixed
     */
    public function equipment(){
        // 获取健身器材订单信息
        $public_where = [
            'status'=>1,
            'category'=>'equipment',
        ];
        $order = model('Order')->getByWhere($public_where);
        foreach ($order as $value) {
            $value['username'] = model('User')->get($value['user_id'])['username'];
            $value['coursename'] = model('Equipment')->get($value['course_id'])['name'];
        }
        return $this->fetch('',[
             'order'=>$order,
        ]);
    }
}