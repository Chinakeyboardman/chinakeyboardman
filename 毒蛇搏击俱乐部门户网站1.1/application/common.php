<?php

// 应用公共文件
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
// 如果到期时间<现在的时间  显示红色
function expiryTime($time){
    if($time < date('Y-m-d H:i:s',time())){
        $str = "<label style='color:red;'>".$time."</label>";
    }else{
        $str = "<label style='color:#71C671;'>".$time."</label>";

    }
    return $str;
}
// 根据教练id获取教练名
function getCoachById($id){
    return model('Coach')->get($id)['name'];
}
// 根据特长ID获取特长名
function getSpecialById($id){
    return model('Special')->get($id)['special'];
}
// 根据课程ID获取教练名
function getCoachName($id){
    if($id == 0){
        return '';
    }else{
        $coach_id = model('Course')->get($id)['coach_id'];
        $coach_name = model('Coach')->get($coach_id)['name'];
        return $coach_name;
    }
    
}
// 获取课程的分类名
function getCategory($category){
    if($category == 'public'){
        return '团体课';
    }elseif($category == 'privacy'){
        return '私教课';
    }else{
        return '';
    }
}
/*根据课程ID获取课程名*/
function getCourseNameById($id){
    $course_name = model('Course')->get($id)['name'];
    return $course_name;
}
/*调试代码  输出*/
function p($var){
    if(is_bool($var)){
        var_dump($var);
    }else if (is_null($var)){
        var_dump(NULL);
    }else {
        echo '<pre style="position: relative;z-index: 1000;padding: 10px;border-radius: 5px;background: #f5f5f5;border: 1px solid #aaa;font-size: 14px;line-height: 18px;opacity: 0.9;">'.print_r($var,true).'</pre>';
    }
}
/*支付状态*/
function paystatus($status){
    if($status==1){
        $str = "<span class='label label-success radius'>支付成功</span>";
    }elseif($status==0){
        $str = "<span class='label label-danger radius'>支付失败</span>";
    }
    return $str;
}
function status($status){
    if($status==1){
        $str = "<span class='label label-success radius'>正常</span>";
    }elseif($status==0){
        $str = "<span class='label label-danger radius'>待审</span>";

    }else{
        $str = "<span class='label label-danger radius'>删除</span>";

    }
    return $str;
}

/**
 * @param $url
 * @param int $type 0 get  1 post
 * @param array $data
 */
function doCurl($url,$type=0,$data=[]){
    $ch = curl_init();
    //设置选项
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//如果成功直接返回结果,不把内容输出来
    curl_setopt($ch,CURLOPT_HEADER,0);//不需要将head头输出来
    if($type==1){
        //post
        curl_setopt($ch,CURLOPT_POST,1);//post方式
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    }
    //执行并获取内容
    $output = curl_exec($ch);
    //释放curl句柄
    curl_close($ch);
    return $output;
}
//对应waiting.html
function bisRegister($status){
    if($status==1){
        $str = "入驻申请成功";
    }else if($status==0){
        $str = "待审核，审核后后平台方会发送邮件通知，请关注邮件";
    } else if($status==2){
        $str = "非常抱歉，您提交的材料不符合条件，请重新提交";
    }else{
        $str = "该申请已被删除";
    }
    return $str;
}
/**
 * 公用的分页样式
 */
function pagination($obj){
if(!$obj){
    return '';
}
    //优化方案
    $params = request()->param();
    return '<div class="cl pd-5 bg-1 bk-gray mt-20 tp5-o2o">'.$obj->appends($params)->render().'</div>';
}