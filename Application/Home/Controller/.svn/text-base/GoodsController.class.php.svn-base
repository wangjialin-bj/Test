<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;

/**
 * 商品控制器
 *
 * 购物车方法
 *
 * 订单控方法
 */
class GoodsController extends HomeController{
	//没有任何方法，直接执行HomeController的_empty方法
	//请不要删除该控制器
	protected function _initialize()
	{
		parent::_initialize();
		if(!UID)
		{
			$this->error('请登录后再使用！' , U('Home/index'));
		}
		$this->assign('guide' , '在线商店');
	}

	/*购物车*/
	public function index()
	{
		$goodslist = session('goods_cart');
		$total_price = 0;
		foreach($goodslist as $key=>$val){
			$all_price = $val['goods_price'] * $val['goods_account'];
			$goodslist[$key]['goods_all_price'] = $all_price ;
			$total_price += $all_price;
		}
		$this->assign('total_price' , $total_price);
		$this->assign('list' , $goodslist);
		$this->display();
	}

	/*
	* 更改goods_cart状态
	*/
	public function changePriceStatus()
	{
		if(!empty(session('goods_cart')))
		{
			$goods_info = session('goods_cart');
			$goods_id = I('Post.goods_id');
			$change_type = I('Post.type');
			$goods_account = I('Post.goods_account' , 0);
			if(!$goods_id || !$change_type)
			{
				echo 0;die;
			}
			switch ($change_type) {
				case 'add':
					$goods_info[$goods_id]['goods_account'] += 1;
					$count = $this->getGoodsTotalAccount($goods_id , $goods_info);
					if($count < $goods_info[$goods_id]['goods_account'])
					{
						$goods_info[$goods_id]['goods_account'] -= 1;
						session('goods_cart' , $goods_info);
						echo json_encode(array('info' => '库存不足'));die;
					}
					$goods_info[$goods_id]['goods_all_price'] = $goods_info[$goods_id]['goods_all_price'] + $goods_info[$goods_id]['goods_price'];
					break;
				case 'del':
					$goods_info[$goods_id]['goods_account'] -= 1;
					$goods_info[$goods_id]['goods_all_price'] = $goods_info[$goods_id]['goods_all_price'] - $goods_info[$goods_id]['goods_price'];
					break;
				case 'mutli':
					$old_count = $goods_info[$goods_id]['goods_account'];
					$old_total_price = $this->getGoodsTotalPrice($goods_info);
					$goods_info[$goods_id]['goods_account'] = $goods_account;
					$count = $this->getGoodsTotalAccount($goods_id , $goods_info);
					if($count < $goods_info[$goods_id]['goods_account'])
					{
						$goods_info[$goods_id]['goods_account'] = $old_count;
						session('goods_cart' , $goods_info);
						echo json_encode(array('info' => '库存不足' , 'old' => $old_count ,'price' => $old_total_price));die;
					}
					$goods_info[$goods_id]['goods_all_price'] = $goods_info[$goods_id]['goods_price'] * $goods_account;
					break;
				default:
					exit(0);
					break;
			}
			session('goods_cart' , $goods_info);
			$goods_info[$goods_id]['total_price'] = $this->getGoodsTotalPrice($goods_info);
			//ajax 页面不刷新
			if(!$goods_account){
				$goods_info[$goods_id]['goods_all_price'] += $goods_info[$goods_id]['goods_price'];
			}
			echo json_encode($goods_info[$goods_id]);die;
		}else{
			echo 0;die;
		}
	}
	/*商品列表*/
	public function goodslist()
	{
		$maps['status'] = 0;// 1 下架 -1删除
		$goods_list = M('Goods')->field(true)->where($maps)->order('create_time desc')->select();
		$this->assign('list' , $goods_list);
		$this->display('Goods/list');
	}

	//删除某条信息
	public function delGoodsInfo()
	{
		$goods_id = I('Post.goods_id');
		if(!empty(session('goods_cart')))
		{
			$goods_info = session('goods_cart');
			unset($goods_info[$goods_id]);
			session('goods_cart' , $goods_info);
			$total_price = $this->getGoodsTotalPrice($goods_info);
			if ($total_price) {
				echo json_encode(array('total_price'=>$total_price));die;
			}
			echo json_encode(array('info' => 'empty'));die;
		}
		echo 0;die;
	}

	//批量删除
	public function delGoodsIdsInfo()
	{
		$goods_ids = rtrim(I('Post.goods_ids') , '#');
		$ids_arr = explode('#', $goods_ids);
		$goods_info = session('goods_cart');
		foreach($ids_arr as $key => $val)
		{
			unset($goods_info[$val]);
		}
		session('goods_cart' , $goods_info);
		$total_price = $this->getGoodsTotalPrice($goods_info);
		if ($total_price) {
			echo json_encode(array('total_price'=>$total_price ,'goods_ids'=>$goods_ids));die;
		}
		echo json_encode(array('info' => 'empty'));die;
	}
	//加入购物车
	public function addGoodsCart()
	{
		$goods_id = I('Post.goods_id');
		$goods_name = I('Post.goods_name');
		$goods_price = I('Post.goods_price');
		$goods_account = 1;

		if(!empty(session('goods_cart')))
		{
			$goods_info = session('goods_cart');
			if($goods_info[$goods_id])
			{
				$goods_info[$goods_id]['goods_account'] += 1;
			}
			else
			{
				$goods_info[$goods_id]['goods_account'] = 1;
				$goods_info[$goods_id]['goods_name'] = $goods_name;
				$goods_info[$goods_id]['goods_price'] = $goods_price;
			}
			session('goods_cart' , $goods_info);
		}
		else
		{
			$goods_info = array();
			$goods_info[$goods_id] = array();

			$goods_info[$goods_id]['goods_account'] = 1;
			$goods_info[$goods_id]['goods_name'] = $goods_name;
			$goods_info[$goods_id]['goods_price'] = $goods_price;

			session('goods_cart' , $goods_info);
		}
		echo 1;die;
	}

	private function getGoodsTotalPrice($goodslist)
	{
		$total_price = 0;
		if(empty($goodslist)) return $total_price;
		foreach($goodslist as $key=>$val){
			$all_price = $val['goods_price'] * $val['goods_account'];
			$goodslist[$key]['goods_all_price'] = $all_price ;
			$total_price += $all_price;
		}
		return $total_price;
	}

	private function getGoodsTotalAccount($goods_id , $goods_info)
	{
		$counts = M('Goods')->field('goods_count')->find($goods_id);
		$count = intval($counts['goods_count']) > 0 ? intval($counts['goods_count']) : 0;
		return $count;
	}
}
