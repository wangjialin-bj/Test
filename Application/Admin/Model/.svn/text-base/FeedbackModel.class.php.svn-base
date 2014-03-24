<?php
/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2014-03-06 14:47:00
 * @version $Id$
 */
namespace Admin\Model;
use Think\Model;

class FeedbackModel extends Model {

	/*
	* 显示未删除所有的反馈列表
	*/
	public function _list($uid = 0 , $sort = 'ctime desc' , $field = true)
	{
		$map = array('status' => -1);
		return $this->field($field)->where($map)->order($sort)->select();
	}

	/*
	* 根据feedback_id获取单条反馈信息
	*/
	public function getFeedbackInfoById($feedback_id)
	{
		if(!$feedback_id) return false;
		return $this->field(true)->find($feedback_id);
	}

	/*更新反馈信息 where*/
	public function saveEmailInfo($feedback_id , $data = array())
	{
		if($data && $feedback_id)
		{
			$map['feedback_id'] = $feedback_id ;
			$re = $this->where($map)->save($data);
			if(!re)
			{
				return false;
			}
			return true;
		}
		return false;
	}
}