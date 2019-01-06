<?php
/**
 * author: Administrator.
 * createTime: 2018/1/29 22:19
 * description:
 */

namespace app\common\validate;


use think\Validate;

class Deal extends Validate{
    protected $rule=[
        'id'=>'require|number',
        'status'=>'require|in:-1,0,1',
        'name'=>'require|max:25',
        'city_id'=>'require',
        'category_id'=>'require',
        'start_time'=>'require',
        'end_time'=>'require',
        'total_count'=>'require',
        'origin_price'=>'require',
        'current_price'=>'require',
        'coupons_begin_time'=>'require',
        'coupons_end_time'=>'require',
    ];
    //场景设置
    protected $scene=[
        'add'=>['name','city_id','category_id','start_time','end_time','total_count','origin_price','current_price','coupons_begin_time','coupons_end_time'],//团购商品添加
        'status'=>['id','status'],//修改状态
    ];
}