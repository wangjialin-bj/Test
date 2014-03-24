<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 鲁国行人甲 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use Think\Controller;

/**
 * 空模块，主要用于显示404页面，请不要删除
 */
class PaypalController extends HomeController{
	/*
	*获取用户支付后的信息。
	*/
	public function getReturnInfo()
	{
		// \Think\Log::write(json_encode($_REQUEST),'http_request');
		$arr = json_decode('{"id":"10","mc_gross":"0.01","protection_eligibility":"Eligible","address_status":"confirmed","payer_id":"ZV7QQ4H3G2CA4","tax":"0.00","address_street":"1 Main St","payment_date":"20:12:15 Feb 23, 2014 PST","payment_status":"Completed","charset":"windows-1252","address_zip":"95131","first_name":"wang","option_selection1":"stephen","option_selection2":"shanghai china","mc_fee":"0.01","address_country_code":"US","address_name":"wang jialin","notify_version":"3.7","custom":"","payer_status":"verified","business":"dz5362_3@qq.com","address_country":"United States","address_city":"San Jose","quantity":"1","verify_sign":"An5ns1Kso7MWUdW4ErQKJJJ4qi4-A6UloskFmtCnVWNiHDrT97-4.BcI","payer_email":"dz5362_1@qq.com","option_name1":"customerId","option_name2":"address","txn_id":"44R069196Y104801P","payment_type":"instant","last_name":"jialin","address_state":"CA","receiver_email":"dz5362_3@qq.com","payment_fee":"0.01","receiver_id":"3BPDJJ3RDXNRU","txn_type":"web_accept","item_name":"memberpay","mc_currency":"USD","item_number":"","residence_country":"US","test_ipn":"1","handling_amount":"0.00","transaction_subject":"","payment_gross":"0.01","shipping":"0.00","ipn_track_id":"874002af8c57b"}');
		dump($arr);
	}

	public function setOrder()
	{
		if(IS_POST)
		{
			$account = I('Post.account');
			if($account == 0)
			{
				$this->error('必须大于0');
			}
			if(D('Order')->addOrder($data))
			{
				$this->redirect("Home/User/index",array('types'=>'order'));
			}
			else
			{

			}
			dump($re);
		}
		else
		{
			$this->error('Error!');
		}
	}
}
