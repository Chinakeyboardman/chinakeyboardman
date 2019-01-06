<?php 
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Request;
use think\Db;
class Notice extends Base{

	/*公告栏列表*/ 
    public function index(){
    	$notice = model('Notice')->getCurrentTable();
        return $this->fetch('',[
        	'notice'=>$notice,
        ]);
    }
    /*添加公告*/
    public function add(){
        return $this->fetch();
    }
    /*编辑公告*/
    public function edit(){
        $id = Request::instance()->param('id');
        $notice = model('Notice')->get($id);
        return $this->fetch('',[
            'notice'=>$notice,
        ]);
    }
    /*保存公告*/
    public function save(){
    	$notice = Request::instance()->param();
        if(!empty($notice['id'])){
            return $this->update($notice);//这样代码就不会往下面走了
        }
        $notice['create_time'] = date('Y-m-d h:i:s',time());
    	$notice['update_time'] = date('Y-m-d h:i:s',time());
        $res = model('Notice')->add($notice);
        if($res){
            $this->success('新增成功',url('notice/index'));
        }else{
            $this->error('新增失败');
        }
    }
    /*更新公告*/
    public function update($data){
        $data['update_time'] = date('Y-m-d h:i:s',time());
        $result =  model('Notice')->save($data,['id'=>intval($data['id'])]);
        if($result){
            $this->success('更新成功',url('notice/index'));
        }else{
            $this->error('更新失败');

        }
    }
}


 ?>