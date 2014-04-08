<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi;

/**
 * 后台账户支付控制器
 * @author dz5362 <dz5362@qq.com>
 */
class AccountController extends AdminController {

	public function msglogs()
	{
		$REQUEST    =   (array)I('request.');
		$maps = array();

		if(!empty($REQUEST['start']) && !empty($REQUEST['end']) )
		{
			$maps['reply_date'] = array('between' , array($REQUEST['start'] ,$REQUEST['end']));
		}

		if(!empty($REQUEST['reply_id']))
		{
			$maps['reply_id'] = $REQUEST['reply_id'];
		}
		else
		{
			$maps['reply_id'] = array('gt' , 0);
		}

		$msgLogs = D('MsgLogs');

		$fields = 'sum(msg_price) as msg_price_all , sum(profit) as profit_all , reply_id , tid , reply_date , max(reply_date) as end_time , min(reply_date) as start_time';

		$total = count($msgLogs->field($fields)->where($maps)->group('reply_id')->select());

		if( isset($REQUEST['r']) ){
			$listRows = (int)$REQUEST['r'];
		}else{
			$listRows = C('LIST_ROWS') > 0 ? 2 : 10;
		}

		$page = new \Think\Page($total, $listRows, $REQUEST);

		if($total>$listRows){
			$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		}
		$p =$page->show();
		$this->assign('_page', $p? $p: '');
		$this->assign('_total',$total);
		$limit_str = $page->firstRow.','.$page->listRows;

		$list = $msgLogs->field($fields)->where($maps)->group('reply_id')->limit($limit_str)->order()->select();

		foreach($list as $key=>$val)
		{
			$list[$key]['price'] =(float)$val['msg_price_all'] -  ($val['profit_all'] != null ? (float)$val['profit_all'] : (float)'0.00');
		}

		$this->assign('_list' , $list);
		$this->meta_title = 'MsgLogs列表';
		$this->display();
	}
}