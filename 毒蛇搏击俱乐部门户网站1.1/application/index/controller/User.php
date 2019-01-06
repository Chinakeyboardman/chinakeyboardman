<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Db;
class User extends Controller
{
    /**
     * 登录
     * @return mixed
     */
    public function login(){
        if(request()->isPost()){
            $data = input('post.');
            //对数据进行检验  validate
            $validate=validate('User');
            if(!$validate->scene('login')->check($data)){
                $this->error($validate->getError());
            }
            //根据用户名查看User表中是否有此数据
            try{
//            $ret = model('User')->get(['username'=>$data['username']]);
                $ret = model('User')->getUserByUsername($data['username']);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }
            if(!$ret || $ret->status !=1){
                $this->error('该用户不存在');
            }
            if($ret->password !=md5($data['password'].$ret->code)){
                $this->error('密码不正确');
            }
            model('User')->updateById(['last_login_time'=>time()],$ret->id);
            //将登录的账号保存到session
            session('User',$ret,'user');
            return $this->success('登录成功',url('index/index'));
        }else{
            //获取session里面的值，如果session里面已经有值了，那就直接跳到index/index
            $user = session('User','','user');
            if($user && $user->id){
                return $this->redirect(url('index/index'));
            }
            return $this->fetch();
    }
    }


    /**
     * 注册
     * @return mixed
     */
    public function register(){
        if(request()->isPost()){
            $data = input('post.');
            $uniquename = model('User')->get(['username'=>$data['username']]);
            if(sizeof($uniquename)){
                $this->error('该用户名已经注册，请重新填写~~~');
            }
            $uniqueemail = model('User')->get(['email'=>$data['email']]);
            if(sizeof($uniqueemail)){
                $this->error('该邮箱已经注册，请重新填写~~~');
            }
            if(!captcha_check($data['verifycode'])){
                $this->error('验证码不正确');
            }
            //验证数据是否合法
            $validate = validate('User');
            if(!$validate->scene('register')->check($data)){
                $this->error($validate->getError());
            }
            //密码和确认密码是否相同
            if($data['password']!=$data['repassword']){
                $this->error('两次输入的密码不一致！');
            }
            //组装数据
            //密码code加严值
           $data['code']=mt_rand(100,10000);
            $userData = [
                'username'=>$data['username'],
                'email'=>$data['email'],
                'code'=>$data['code'],
                'password'=>md5($data['password']. $data['code']),
                'is_admin'=>0,
            ];
            try{
            $res = model('User')->add($userData);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }
            if($res){
                $this->success('用户注册成功',url('user/login'));
            }else{
                $this->error('用户注册失败');
            }
        }else{
            return $this->fetch();
        }
    }
    /**
     * 登出
     */
    public function logout(){
        session(null,'user');
        $this->redirect(url('user/login'));
    }
    /*会员信息*/ 
    public function info(){
        $id = Request::instance()->param('id');
        $user = model('User')->get($id);
        if(empty($user['image'])){
            $user['image_null'] = true;
        }else{
            $user['image_null'] = false;
        }
        return $this->fetch('',[
            'user'=>$user,
            'title'=>'个人信息',
            'controller'=>'register',
        ]);
    }
}
