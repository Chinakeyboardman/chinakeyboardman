<?php 
namespace  app\common\model;
use app\common\model\BaseModel;
class User extends BaseModel{
	public function getUsers(){
		$data=['status'=>1];
		$order=['id'=>'desc'];
		return $this->where($data)->order($order)->paginate();
	}
	/*根据状态查找用户信息*/
	public function getUsersByStatus($status){
		$data=['status'=>$status];
		$order=['id'=>'desc'];
		return $this->where($data)->order($order)->paginate();
	}
	/**
     * 根据用户名获取用户信息
     */
    public function getUserByUsername($username){
        if(!$username){
            exception('用户名不合法');
        }
        $data=[
            'username'=>$username,
        ];
        $res = $this->where($data)->find();
        return $res;
    }
}

 ?>