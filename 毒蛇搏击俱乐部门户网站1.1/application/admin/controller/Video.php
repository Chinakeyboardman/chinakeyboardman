<?php 
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Request;
use think\Db;
class Video extends Base{
	 
    public function index(){
    	$video = model('Video')->get(1);
        return $this->fetch('',[
        	'video'=>$video,
        ]);
    }

    /*保存首页视频*/
    public function save(){
    	$video = Request::instance()->param();
    	$video['update_time'] = date('Y-m-d h:i:s',time());
	        $result = model('Video')->save($video, ['id' => intval($video['id'])]);
	        if ($result)
	        {
	            $this->success('更新成功');
	        }
	        else
	        {
	            $this->error('更新失败');
	        }
    }
}


 ?>