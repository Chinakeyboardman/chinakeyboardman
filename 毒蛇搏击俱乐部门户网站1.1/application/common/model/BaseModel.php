<?php
/**
 * BaseModel 公共的Model层
 */
namespace app\common\model;

use think\Model;

class BaseModel extends Model{
    protected $autoWriteTimeStamp=true;
    /*数据入库*/
    public function add($data){
        $data['status']=1;
        $this->save($data);
        return $this->id;
    }

    /*更新收据*/
    public function updateById($data,$id){
        return $this->allowField(true)->save($data,['id'=>$id]);
    }
    /*获取当前数据表的数据*/
    public function getCurrentTable(){
        $where = [
            'status'=>1,
        ];
        $order = [
            'id'=>'desc',
        ];
        return $this->where($where)->order($order)->paginate();
    }
    /*条件查询*/
    public function getByWhere($where){
        $order = [
            'id'=>'desc',
        ];
        return $this->where($where)->order($order)->paginate();
    }
}