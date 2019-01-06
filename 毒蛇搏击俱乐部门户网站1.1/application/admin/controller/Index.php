<?php
namespace app\admin\controller;
use think\Controller;
class Index extends Controller
{
    /*后台首页*/
    public function index()
    {
        // 查看session里面是否有用户值  没有的话去登录  有的话直接进入后台首页
    	$user = session('UserAdmin','','user');
            if(!$user || !$user->id){
                return $this->redirect(url('user/login'));
            }else{
                $username = $user['username'];
            }
    	 
        return $this->fetch('',[
        	'username'=>$username,
        ]);
    }
    /*欢迎页面*/
    public function welcome(){
          $locations = \Map::getLngLat('江苏省南京市金陵科技学院')['result']['location'];

        return  $this->fetch('',[
            'mapstr'=>$locations['lng'].','.$locations['lat'],
            ]);
    }
}
