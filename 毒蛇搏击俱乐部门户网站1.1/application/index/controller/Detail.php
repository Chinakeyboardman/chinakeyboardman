<?php

namespace app\index\controller;

use think\Request;
use think\Db;
class Detail extends Base{
    /**
     * 团体课详情页
     */
    public function index(){
        // 获取当前用户的信息
        $user = session('User','','user');
        if(!$user || !$user->id){
            $userId=0;
        }else{
            $userId=$user->id;
        }
        // 获取id
        $id = Request::instance()->param('id');
        if(!intval($id)){
            $this->error('ID不合法');
        }
        // 根据ID获取课程信息
        $deal = model('Course')->get($id);
        // 查询课程对应的教练信息
        $coach = model('Coach')->get($deal['coach_id']);
        // 查看当前用户有没有购买此课程   如果购买了  到期了吗   到期：橙色按钮  没到期：灰色按钮
        $isExistence_where = [
            'status'=>1,
            'user_id'=>$userId,
            'course_id'=>$deal['id'],
            'category'=>'public',
            'expiry_time'=>["gt",date('Y-m-d H:i:s',time())],
        ];
        $isExistence = model('Order')->getByWhere($isExistence_where)->count();
        if($isExistence == 0){
            $existence = 0;
        }else{
            $existence = 1;
        }
        return $this->fetch('',[
            'deal'=>$deal,
            'coach'=>$coach,
            'userId'=>$userId,
            'existence'=>$existence,
        ]);
    }
    /**
     * 单次服务详情页
     */
    public function single(){
        // 获取当前用户的信息
        $user = session('User','','user');
        if(!$user || !$user->id){
            $userId=0;
        }else{
            $userId=$user->id;
        }
        // 获取id
        $id = Request::instance()->param('id');
        if(!intval($id)){
            $this->error('ID不合法');
        }
        // 根据ID获取课程信息
        $deal = model('Single')->get($id);
        // 判断当前用户有没有参加次活动   如果已经参加就不可以再次购买  因为此为单次服务
        $isExistence_where = [
            'status'=>1,
            'user_id'=>$userId,
            'course_id'=>$deal['id'],
            'category'=>'single',
        ];
        $isExistence = model('Order')->getByWhere($isExistence_where)->count();
        if($isExistence == 0){
            $existence = 0;
        }else{
            $existence = 1;
        }
        // 查询课程对应的教练信息
        return $this->fetch('',[
            'deal'=>$deal,
            'userId'=>$userId,
            'existence'=>$existence,
        ]);
    }
    /**
     * 会员卡详情页
     */
    public function card(){
        // 获取当前用户的信息
        $user = session('User','','user');
        if(!$user || !$user->id){
            $userId=0;
        }else{
            $userId=$user->id;
        }
        // 获取id
        $id = Request::instance()->param('id');
        if(!intval($id)){
            $this->error('ID不合法');
        }
        // 根据ID获取课程信息
        $deal = model('Card')->get($id);
        // 判断当前用户有没有参加次活动   如果已经参加就不可以再次购买  因为此为单次服务
        $isExistence_where = [
            'status'=>1,
            'user_id'=>$userId,
            'course_id'=>$deal['id'],
            'category'=>'card',
            'expiry_time'=>["gt",date('Y-m-d H:i:s',time())],
        ];
        $isExistence = model('Order')->getByWhere($isExistence_where)->count();
        if($isExistence == 0){
            $existence = 0;
        }else{
            $existence = 1;
        }
        // 如果已经当前用户已经买了高级会员卡 那么就无需买团课卡和器材卡了
        $senior_where = [
            'status'=>1,
            'category'=>'card',
            'user_id'=>$userId,
            'course_id'=>3,
            'expiry_time'=>["gt",date('Y-m-d H:i:s',time())],
        ];
        $seniorCard = model('Order')->getByWhere($senior_where)->count();
        // 如果当前用户已经买了团体课卡和器材卡  那么久无需买高级会员卡了
        $publicAndEquipment_where1 = [
            'status'=>1,
            'category'=>'card',
            'user_id'=>$userId,
            'course_id'=>1,
            'expiry_time'=>["gt",date('Y-m-d H:i:s',time())],
        ];
        $publicAndEquipment_where2 = [
            'status'=>1,
            'category'=>'card',
            'user_id'=>$userId,
            'course_id'=>2,
            'expiry_time'=>["gt",date('Y-m-d H:i:s',time())],
        ];
        $publicAndEquipment1 = model('Order')->getByWhere($publicAndEquipment_where1)->count();
        $publicAndEquipment2 = model('Order')->getByWhere($publicAndEquipment_where2)->count();
        if($publicAndEquipment1 == 1 && $publicAndEquipment2 == 1){
            $publicAndEquipment = 1;
        }else{
            $publicAndEquipment = 0;
        }
        // p($publicAndEquipment);die;
        // 查询课程对应的教练信息
        return $this->fetch('',[
            'deal'=>$deal,
            'userId'=>$userId,
            'existence'=>$existence,
            'seniorCard'=>$seniorCard,
            'publicAndEquipment'=>$publicAndEquipment,
        ]);
    }
    /**
     * 私教课详情页
     */
    public function pri(){
        // 获取当前用户的信息
        $user = session('User','','user');
        if(!$user || !$user->id){
            $userId=0;
        }else{
            $userId=$user->id;
        }
        // 获取id
        $id = Request::instance()->param('id');
        if(!intval($id)){
            $this->error('ID不合法');
        }
        // 根据ID获取课程信息
        $deal = model('Course')->get($id);
        $deal_special = model('Special')->get($deal['special'])['special'];
        /*拥有该私教所需特长的教练名*/
        // 该私教课所需的特长ID
        $currentCourseSpecialId = $deal['special'];
        // 所有教练的信息
        $coach = model('Coach')->getCurrentTable();
        // 匹配的教练id
        foreach ($coach as $value) {
            $coach_special[] = $value['special'];
            if(in_array($currentCourseSpecialId, explode(',', $value['special']))){
                $correct_coach[] = $value['id'];
            }
        }
        /*/拥有该私教所需特长的教练名*/

        // 已经预约的时间
        $yuyue_where = [
            'status'=>1,
            'course_id'=>$id,
        ];
        // 
        $yuyue = model('Order')->getByWhere($yuyue_where);
        // 判断当前用户有没有参加次活动   如果已经参加就不可以再次购买  因为此为单次服务
        $isExistence_where = [
            'status'=>1,
            'user_id'=>$userId,
            'course_id'=>$deal['id'],
            'category'=>'privacy',
        ];
        $isExistence = model('Order')->getByWhere($isExistence_where)->count();
        if($isExistence == 0){
            $existence = 0;
        }else{
            $existence = 1;
        }
        // 查询课程对应的教练信息
        return $this->fetch('',[
            'deal'=>$deal,
            'userId'=>$userId,
            'deal_special'=>$deal_special,
            'correct_coach'=>$correct_coach,
            'yuyue'=>$yuyue,
            'existence'=>$existence,
        ]);
    }
     /**
     * 教练详情页
     */
    public function coach(){
        // 获取id
        $id = Request::instance()->param('id');
        if(!intval($id)){
            $this->error('ID不合法');
        }
        // 根据ID获取教练信息
        $deal = model('Coach')->get($id);
        $deal_special = explode(',', $deal['special']);
        array_pop($deal_special);
        foreach ($deal_special as $value) {
            $special[] = model('Special')->get($value);
        }
        // 教练对应的课程信息
        $where = [
            'status'=>1,
            'coach_id'=>$deal['id'],
        ];
        $course = model('Course')->getByWhere($where);
        return $this->fetch('',[
            'deal'=>$deal,
            'course'=>$course,
            'deal_special'=>$deal_special,
            'special'=>$special,
        ]);
    }
    /**
     * 健身器材详情页
     */
    public function equipment(){
        // 获取当前用户的信息
        $user = session('User','','user');
        if(!$user || !$user->id){
            $userId=0;
        }else{
            $userId=$user->id;
        }
        // 获取id
        $id = Request::instance()->param('id');
        if(!intval($id)){
            $this->error('ID不合法');
        }
        // 根据ID获取器材信息
        $equipment = model('Equipment')->get($id);
        // 查看当前用户有没有购买此器材   如果购买了  到期了吗   到期：橙色按钮  没到期：灰色按钮
        $isExistence_where = [
            'status'=>1,
            'user_id'=>$userId,
            'course_id'=>$equipment['id'],
            'category'=>'equipment',
            'expiry_time'=>["gt",date('Y-m-d H:i:s',time())],
        ];
        $isExistence = model('Order')->getByWhere($isExistence_where)->count();
        if($isExistence == 0){
            $existence = 0;
        }else{
            $existence = 1;
        }
        return $this->fetch('',[
            'deal'=>$equipment,
            'userId'=>$userId,
            'existence'=>$existence,
        ]);
    }
     /*弹框页面    购买产品需要积分*/
    public function buy(){
            $user = session('User','','user');
            if(!$user || !$user->id){
                return $this->redirect(url('user/login'));
            }else{
                $data = Request::instance()->param();
                $user_id = $user['id'];
                $user = model('User')->get($user_id);
                $contact = model('Contact')->get(1);
                return $this->fetch('',[
                    'user'=>$user,
                    'data'=>$data,
                    'contact'=>$contact,
        ]);
            }
    }
      /*弹框页面    购买单次服务*/
    public function participate(){
            $user = session('User','','user');
            if(!$user || !$user->id){
                return $this->redirect(url('user/login'));
            }else{
                $data = Request::instance()->param();
                $user_id = $user['id'];
                $user = model('User')->get($user_id);
                $contact = model('Contact')->get(1);
                return $this->fetch('',[
                    'user'=>$user,
                    'data'=>$data,
                    'contact'=>$contact,
        ]);
            }
    }
     /*弹框页面    购买器材*/
    public function buy_equip(){
            $user = session('User','','user');
            if(!$user || !$user->id){
                return $this->redirect(url('user/login'));
            }else{
                $data = Request::instance()->param();
                // $data['term'] = model('Equipment')->get($data['chanpin_id'])['term'];
                $user_id = $user['id'];
                $user = model('User')->get($user_id);
                $contact = model('Contact')->get(1);
                return $this->fetch('',[
                    'user'=>$user,
                    'data'=>$data,
                    'contact'=>$contact,
        ]);
            }
    }
     /*弹框页面    购买会员卡*/
    public function buy_card(){
            $user = session('User','','user');
            if(!$user || !$user->id){
                return $this->redirect(url('user/login'));
            }else{
                $data = Request::instance()->param();
                // $data['term'] = model('Card')->get($data['chanpin_id'])['term'];
                $user_id = $user['id'];
                $user = model('User')->get($user_id);
                $contact = model('Contact')->get(1);
                return $this->fetch('',[
                    'user'=>$user,
                    'data'=>$data,
                    'contact'=>$contact,
        ]);
            }
    }
      /*弹框页面    预约产品 */
    public function yuyue(){
            $user = session('User','','user');
            if(!$user || !$user->id){
                return $this->redirect(url('user/login'));
            }else{
                $data = Request::instance()->param();
                $user_id = $user['id'];
                $user = model('User')->get($user_id);
                $contact = model('Contact')->get(1);
                return $this->fetch('',[
                    'user'=>$user,
                    'data'=>$data,
                    'contact'=>$contact,
        ]);
            }
    }
    /*购买产品*/
    public function goumai(){
        $data = Request::instance()->param();
        // 将购买记录写入数据库
        $user_course['user_id']=$data['userid'];
          $user_course['course_id']=$data['chanpin_id'];
          $user_course['price']=$data['needjifen'];
          $user_course['term']=$data['term'];
          $user_course['category']='public';
          $user_course['create_time']=date('Y-m-d H:i:s',time());
          $user_course['update_time']=date('Y-m-d H:i:s',time());
          $user_course['expiry_time']=date("Y-m-d H:i:s",strtotime("+".$data['term']." month"));
          $result = model('Order')->add($user_course);
        if($result){
          // 更新用户的积分数
        $user=[
            'jifen'=>$data['userjifen'] - $data['needjifen'],
        ];
        $res = model('User')->save($user,['id'=>intval($data['userid'])]);
        if($res){
                echo 1;
            }else{
                echo 0;
            }
        }else{
            echo 0;
        }
    }
    /*参加活动*/
    public function participate_single(){
        $data = Request::instance()->param();
        // 将购买记录写入数据库
        $user_course['user_id']=$data['userid'];
          $user_course['course_id']=$data['chanpin_id'];
          $user_course['price']=$data['needjifen'];
          $user_course['category']='single';
          $user_course['create_time']=date('Y-m-d H:i:s',time());
          $user_course['update_time']=date('Y-m-d H:i:s',time());
          $result = model('Order')->add($user_course);
        if($result){
          // 更新用户的积分数
        $user=[
            'jifen'=>$data['userjifen'] - $data['needjifen'],
        ];
        $res = model('User')->save($user,['id'=>intval($data['userid'])]);
        if($res){
                echo 1;
            }else{
                echo 0;
            }
        }else{
            echo 0;
        }
    }
     /*购买器材*/
    public function goumaiequip(){
        $data = Request::instance()->param();
        // 将购买记录写入数据库
          $user_course['user_id']=$data['userid'];
          $user_course['course_id']=$data['chanpin_id'];
          $user_course['price']=$data['needjifen'];
          $user_course['term']=$data['term'];
          $user_course['category']='equipment';
          $user_course['create_time']=date('Y-m-d H:i:s',time());
          $user_course['update_time']=date('Y-m-d H:i:s',time());
          $user_course['expiry_time']=date("Y-m-d H:i:s",strtotime("+".$data['term']." month"));
          $result = model('Order')->add($user_course);
        if($result){
          // 更新用户的积分数
        $user=[
            'jifen'=>$data['userjifen'] - $data['needjifen'],
        ];
        $res = model('User')->save($user,['id'=>intval($data['userid'])]);
        if($res){
                echo 1;
            }else{
                echo 0;
            }
        }else{
            echo 0;
        }
    }
     /*购买会员卡*/
    public function goumaicard(){
        $data = Request::instance()->param();
        // 将购买记录写入数据库
          $user_course['user_id']=$data['userid'];
          $user_course['course_id']=$data['chanpin_id'];
          $user_course['price']=$data['needjifen'];
          $user_course['term']=$data['term'];
          $user_course['category']='card';
          $user_course['create_time']=date('Y-m-d H:i:s',time());
          $user_course['update_time']=date('Y-m-d H:i:s',time());
          $user_course['expiry_time']=date("Y-m-d H:i:s",strtotime("+".$data['term']." month"));
          $result = model('Order')->add($user_course);
          // 按照会员卡的类型给当前用户添加订单
          // 获取团体课
                $public_where = [
                    'status'=>1,
                    'category'=>'public',
                ];
                $public_course = model('Course')->getByWhere($public_where);
                $public_i = 0;
                foreach ($public_course as $value) {
                    $public_datas[$public_i]['course_id'] = $value['id'];
                    $public_datas[$public_i]['user_id'] = $user_course['user_id'];
                    $public_datas[$public_i]['price'] = $value['price'];
                    $public_datas[$public_i]['create_time'] = date('Y-m-d H:i:s',time());
                    $public_datas[$public_i]['update_time'] = date('Y-m-d H:i:s',time());
                    $public_datas[$public_i]['category'] = 'public';
                    $public_datas[$public_i]['status'] = 1;
                    $public_datas[$public_i]['coach_id'] = $value['coach_id'];
                    $public_datas[$public_i]['term'] = $user_course['term'];
                    $public_datas[$public_i]['expiry_time'] = $user_course['expiry_time'];
                    $public_datas[$public_i]['coach_name'] = model('Coach')->get($value['coach_id'])['name'];
                    $public_i++;
                }
                // 获取健身器材
                $equipment_where = [
                    'status'=>1,
                ];
                $equipment = model('Equipment')->getByWhere($equipment_where);
                $equipment_i = 0;
                foreach ($equipment as $value) {
                    $equipment_datas[$equipment_i]['course_id'] = $value['id'];
                    $equipment_datas[$equipment_i]['user_id'] = $user_course['user_id'];
                    $equipment_datas[$equipment_i]['price'] = $value['price'];
                    $equipment_datas[$equipment_i]['create_time'] = date('Y-m-d H:i:s',time());
                    $equipment_datas[$equipment_i]['update_time'] = date('Y-m-d H:i:s',time());
                    $equipment_datas[$equipment_i]['category'] = 'equipment';
                    $equipment_datas[$equipment_i]['status'] = 1;
                    $equipment_datas[$equipment_i]['term'] = $user_course['term'];
                    $equipment_datas[$equipment_i]['expiry_time'] = $user_course['expiry_time'];
                    $equipment_i++;
                }
          if($user_course['course_id'] == 1){
                // TODO:将所有团体课加到当前用户
                $r = Db::name('order')->insertAll($public_datas);
            }elseif($user_course['course_id'] == 2){
                // TODO:将所有健身器材加到当前用户
                $r = Db::name('order')->insertAll($equipment_datas);
            }elseif($user_course['course_id'] == 3){
                // TODO:将所有团体课&健身器材加到当前用户
                Db::name('order')->insertAll($public_datas);//如果这个不成功执行 根本就走不到下一步
                $r = Db::name('order')->insertAll($equipment_datas);
            }
        if($result && $r){
          // 更新用户的积分数
        $user=[
            'jifen'=>$data['userjifen'] - $data['needjifen'],
        ];
        $res = model('User')->save($user,['id'=>intval($data['userid'])]);
        if($res){
                echo 1;
            }else{
                echo 0;
            }
        }else{
            echo 0;
        }
    }
     /*预约私教课程*/
    public function goumaipri(){
        $data = Request::instance()->param();
        // 将购买记录写入数据库
          $user_course['user_id']=$data['userid'];
          $user_course['course_id']=$data['chanpin_id'];
          $user_course['price']=$data['needjifen'];
          $user_course['coach_id']=$data['coach_id'];
          $user_course['coach_name']=$data['coach_name'];
          $user_course['yuyue_time']=$data['yuyue_time'];
          $user_course['create_time']=date('Y-m-d H:i:s',time());
          $user_course['update_time']=date('Y-m-d H:i:s',time());
          $user_course['category']='privacy';
          $result = model('Order')->add($user_course);
        if($result){
          // 更新用户的积分数
        $user=[
            'jifen'=>$data['userjifen'] - $data['needjifen'],
        ];
        $res = model('User')->save($user,['id'=>intval($data['userid'])]);
        if($res){
                echo 1;
            }else{
                echo 0;
            }
        }else{
            echo 0;
        }
    }
}