<?php 
namespace app\api\controller;

use think\Controller;

class DeleteImg extends Controller{

	public function index(){
		 $deleteimg = input('post.deleteimg');
		 $deleteimg = str_replace('/', '', $deleteimg);
		 if(file_exists($deleteimg)=='true'){
		 	 if (unlink($deleteimg)==0)
			{
				return show(0,'删除失败');
			}
			else
			{
			return show(1,'删除成功');
			}
		 }else{
		 	return show(-1,'文件不存在');
		 }

		 
	}
}

 ?>