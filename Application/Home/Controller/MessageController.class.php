<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// 
// +----------------------------------------------------------------------
// | Author: dz5362 <dz5362@qq.com> <http://>
// +----------------------------------------------------------------------

namespace Home\Controller;

/**
 * 空模块，主要用于显示404页面，请不要删除
 */
class MessageController extends HomeController{
	//没有任何方法，直接执行HomeController的_empty方法
	//请不要删除该控制器

	protected function _initialize()
    {
        parent::_initialize();
		$this->checkUserLogin();
        $this->assign('guide' , 'message');
    }

	public function index()
	{
		$uid = is_login();
		$types = I('Get.types' , 'unread');
		$mtype = 0;
		if($types == 'unread')
		{
			$mtype = 0;
		}
		if($types == 'readed')
		{
			$mtype = 1;
		}
		$results= D('Message')->getMessageList($mtype,1);

		if($results)
		{
			foreach ($results as $key => $value) {
				$results[$key]['mtime'] = date('Y-m-d H:i:s' , $value['mtime']);
				$results[$key]['username'] = get_username($value['from_uid']);
			}
		}
		else
		{
			$this->error('数据库查询错误，请刷新界面');
		}

		$this->assign('data' , $results);
		$this->assign('action',$types);
		$this->assign('read_type' , $types);
		$this->display();
	}
	/*
		ajax删除消息 假删除
	*/
	public function delMessage()
	{
		$message_id = I('Post.mid');
		$uid = 1;
		if($message_id)
		{
			$data['is_del'] = 1;
			$re = M('Message')->where(array('message_id'=>$message_id , 'uid'=>$uid))
			->save($data);
			if($re)
			{
				echo 1;die;
			}
			else
			{
				echo 0;die;
			}
		}else{
			echo 0;die;
		}
	}

	/*
	* 更改已读状态
	*/
	public function changeMessageStatus()
	{
		$message_id = I('Post.mid');
		$uid = is_login();
		if($message_id)
		{
			$data['is_read'] = 1;
			$re = M('Message')->where(array('message_id'=>$message_id , 'uid'=>$uid))
			->save($data);
			if($re)
			{
				echo 1;die;
			}
			else
			{
				echo 0;die;
			}
		}else{
			echo 0;die;
		}
	}

	public function  changeAllMessageStatus()
	{
		$uid = is_login();
		$data['is_read'] = 1;
		$re = M('Message')->where(array('uid'=>$uid))
			->save($data);
		if ($re) {
			# code...
			echo 1;die;
		}
	}
}
