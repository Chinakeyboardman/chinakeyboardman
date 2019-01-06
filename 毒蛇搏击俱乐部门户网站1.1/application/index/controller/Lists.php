<?php
 
namespace app\index\controller;

use think\Log;
use think\Request;
class Lists extends Base{
    /*根据传过来的值显示相应数据库的数据*/
    public function index(){
        $cat = Request::instance()->param('cat');
        // 团体课
        if($cat == 'public_course'){
            $public_where = [
                'status'=>1,
                'category'=>'public',
            ];
            $data = model('Course')->getByWhere($public_where);
            $title = '团体课程';
            // 私教课
        }elseif($cat == 'privacy_course'){
            $privacy_where = [
                'status'=>1,
                'category'=>'privacy',
            ];
            $data = model('Course')->getByWhere($privacy_where);
            $title = '私教课程';
            // 教练
        }elseif($cat == 'coach'){
            $data = model('Coach')->getCurrentTable();
            $title = '教练信息';
            // 会员卡
        }elseif($cat == 'card'){
            $data = model('Card')->getCurrentTable();
            $title = '会员卡信息';
            // 健身器材
        }elseif($cat == 'equipment'){
            $data = model('Equipment')->getCurrentTable();
            $title = '健身器材信息';
            // 单次服务
        }elseif($cat == 'single'){
            $data = model('Single')->getCurrentTable();
            $title = '单次服务信息';
            // 预防特殊情况 一般情况下不会走到这里
        }else{
            $data='';
            $title = '信息';
        }
        return $this->fetch('',[
            'data'=>$data,
            'title'=>$title,
        ]);
    }
}