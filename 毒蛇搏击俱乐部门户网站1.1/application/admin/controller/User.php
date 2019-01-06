<?php 
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Request;
class User extends Base{
    
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
                $ret = model('User')->getUserByUsername($data['username']);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }
            if(!$ret || $ret->status !=1){
                $this->error('该用户不存在');
            }
            if($ret->is_admin !=1){
                $this->error('你不是管理员');
            }
            if($ret->password !=md5($data['password'].$ret->code)){
                $this->error('密码不正确');
            }
            model('User')->updateById(['last_login_time'=>time()],$ret->id);
            //将登录的账号保存到session
            session('UserAdmin',$ret,'user');
            return $this->success('登录成功',url('index/index'));
        }else{
            //获取session里面的值，如果session里面已经有值了，那就直接跳到index/index
            $user = session('UserAdmin','','user');
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
                // 'email'=>$data['email'],
                'code'=>$data['code'],
                'password'=>md5($data['password']. $data['code']),
                'is_admin'=>1,
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
	public function index(){
		$users =model('User')->getUsers();
		return $this->fetch('',[
			'users'=>$users,
		]);
	}
    /*后台添加会员信息*/
    public function add(){

        return $this->fetch();
    }
    /*编辑会员信息*/
    public function edit(){
        $id = Request::instance()->param('id');
        $user = model('User')->get($id);
        if(empty($user['image'])){
            $user['image_null'] = true;
        }else{
            $user['image_null'] = false;
        }
        return $this->fetch('',[
            'user'=>$user,
        ]);
    }
	/*删除的会员*/
	public function delete(){
		$usersdel = model('User')->getUsersByStatus(-1);
		return $this->fetch('',[
			'usersdel'=>$usersdel,
		]);
	}
    /*保存会员信息*/
    public function save(){
        /**
         * 做下严格判断，看是否是以post方式提交的数据
         */
        if(!request()->isPost()){
            $this->error('请求失败');
        }
        $data = Request::instance()->param();
        $uniquename = model('User')->get(['username'=>$data['username']]);
            if(sizeof($uniquename)){
                $this->error('该用户名已经注册，请重新填写~~~');
            }
            $uniqueemail = model('User')->get(['email'=>$data['email']]);
            if(sizeof($uniqueemail)){
                $this->error('该邮箱已经注册，请重新填写~~~');
            }
        $data['code']=mt_rand(100,10000);
        $data['password']=md5($data['password']. $data['code']);
        unset($data['fileselect']);
        // p($data);die;
         //在修改的时候如果有这个ID就转到update方法
        if(!empty($data['id'])){
            return $this->update($data);//这样代码就不会往下面走了
        }
        $data['create_time'] = date('Y-m-d h:i:s',time());
        $data['update_time'] = date('Y-m-d h:i:s',time());
        //把$data的数据提交给model层
        $res = model('User')->add($data);
        if($res){
            $this->success('新增成功',url('user/index'));
        }else{
            $this->error('新增失败');
        }
    }
    /*更新会员信息*/
    public function update(){
        if(!request()->isPost()){
            $this->error('请求失败');
        }
        $data = Request::instance()->param();
        $data['code']=mt_rand(100,10000);
        $data['password']=md5($data['password']. $data['code']);
        unset($data['fileselect']);
        $data['update_time'] = date('Y-m-d h:i:s',time());
        $result =  model('User')->save($data,['id'=>intval($data['id'])]);
        if($result){
            $this->success('更新成功',url('user/index'));
        }else{
            $this->error('更新失败');

        }
    }
	/*修改状态*/
	/**********************************************************/
	public function status(){
		//获取当前的状态值
		// 表单里面的值随着url传过来，所以是用get获取
		$data = input('param.');
		//看id和status是否合法
		if(empty($data['id'])){
			$this->error('ID不合法');
		}
		if(!is_numeric($data['status'])){
			$this->error('status不合法');
		}
		//获取当前控制器名称
		$model = request()->controller();
		// var_dump($model);
		$res = model($model)->save(['status'=>$data['status']],['id'=>$data['id']]);
		// var_dump($res);
		if($res){
			$this->success('状态更新成功');
		}else{
			$this->error('状态更新失败');
		}
	}
    /*积分充值页面*/
    public function addjifen(){
        $id = Request::instance()->param();
        $user = model('User')->get($id);
        if($user['jifen']=='') $user['jifen']=0;
        return $this->fetch('',[
            'user'=>$user,
        ]);
    }
    /*积分充值操作*/
    public function addjifenAction(){
        $data = Request::instance()->param();
        $user['jifen'] = $data['add_jifen']+$data['origin_jifen'];
        $user['update_time'] = date('Y-m-d h:i:s',time());
        $result =  model('User')->save($user,['id'=>intval($data['id'])]);
        if($result){
            $this->success('更新成功',url('user/index'));
        }else{
            $this->error('更新失败');

        }
    }
}

 ?>