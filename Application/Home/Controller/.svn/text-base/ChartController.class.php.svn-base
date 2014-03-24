<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use Think\Cache;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class ChartController extends HomeController {

	//系统首页
	/*
	 * 0:参数无数据
	 * 2:查询无数据
	 * */
	public function indexChart(){

		$types = I('post.types');
		$name = I('post.name');

		if(empty($types) || empty($name))
		{
			echo 0;die;
		}
	}

	//todo:柱状图
	public function chartuser()
	{
		$this->indexChart();
		$this->display();
	}

	//导出csv文件
	public function outputcsv()
	{
		$time = date('YmdHis');
		header("Content-type:application/vnd.ms-excel");
		$file_name = $time . 'Exploder.csv';
		header(file_name($file_name));
		//数据处理
		$str = "first_name,last_name,Username,other\n";
		$str .="1,2,3,4\n";
		$str .="1,2,3,4\n";
		$str .="1,2,3,4\n";
		$str .="1,2,3,4\n";
		$str .="1,2,3,4\n";
		$str .="1,2,3,4\n";
		echo $str;
		die;
	}
}