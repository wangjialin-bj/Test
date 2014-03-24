<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Addons\Links\Controller;
use Admin\Controller\AddonsController;

class LinksController extends AddonsController{

	public function category()
	{
		$list = M('Links_category')->field(true)->order('id desc')->select();
		$this->assign('_list' , $list);
		$this->display(T('Addons://Links@Links/category'));
	}
	/* 添加友情连接 */
	public function add(){
		$category_list = M('Links_category')->select();
		$current = U('/admin/addons/adminlist/name/Links');
		$this->assign('category_list',$category_list);
		$this->display(T('Addons://Links@Links/edit'));
	}

	/* 添加友情连接分类 */
	public function add_category(){
		$this->display(T('Addons://Links@Links/category_edit'));
	}

	/* 编辑友情连接 */
	public function edit(){
		$id     =   I('get.id','');
		$detail = D('Addons://Links/Links')->detail($id);
		$category_list = M('Links_category')->select();
		$this->assign('category_list',$category_list);
		$this->assign('info',$detail);
		$this->assign('current',$current);
		$this->display(T('Addons://Links@Links/edit'));
	}

	public function category_edit(){
		$id     =   I('get.id','');
		$detail = M('Links_category')->find($id);
		$this->assign('info',$detail);
		$this->assign('current',$current);
		$this->display(T('Addons://Links@Links/category_edit'));
	}

	/* 禁用友情连接 */
	public function forbidden(){
		$id     =   I('get.id','');
		if(D('Addons://Links/Links')->forbidden($id)){
			$this->success('成功禁用该友情连接', Cookie('__forward__'));
		}else{
			$this->error(D('Addons://Links/Links')->getError());
		}
	}

	/* 启用友情连接 */
	public function off(){
		$id     =   I('get.id','');
		if(D('Addons://Links/Links')->off($id)){
			$this->success('成功启用该友情连接',Cookie('__forward__'));
		}else{
			$this->error(D('Addons://Links/Links')->getError());
		}
	}

	/* 删除友情连接 */
	public function del(){
		$id     =   I('get.id','');
		if(D('Addons://Links/Links')->del($id)){
			$this->success('删除成功', Cookie('__forward__'));
		}else{
			$this->error(D('Addons://Links/Links')->getError());
		}
	}

	/* 删除友情连接 */
	public function del_category(){
		$id     =   I('get.id','');
		if(M('Links_category')->delete($id)){
			$this->success('删除成功',addons_url('Links://Links/category'));
		}else{
			$this->error(D('Addons://Links/Links')->getError());
		}
	}

	/* 更新友情连接 */
	public function update(){
		$res = D('Addons://Links/Links')->update();
		if(!$res){
			$this->error(D('Addons://Links/Links')->getError());
		}else{
			if($res['id']){
				$this->success('更新成功', Cookie('__forward__'));
			}else{
				$this->success('新增成功', Cookie('__forward__'));
			}
		}
	}

	/* 更新友情连接分类 */
	public function update_category(){
		$id = I('Post.id');
		$name = I('Post.name');

		if($id)
		{
			$map['id'] = $id;
			$data['name'] = $name;
			if(!M('Links_category')->where($map)->save($data))
			{
				$this->error('更新失败', U('admin/addons/adminlist'));
			}
			$this->success('更新成功', addons_url('Links://Links/category'));
		}
		else
		{
			$data['name'] = $name;
			if(!M('Links_category')->add($data))
			{
				$this->error('新增失败', U('admin/addons/adminlist'));
			}
			$this->success('新增成功', addons_url('Links://Links/category'));
		}
	}
	/**
	 * 批量处理
	 */
	public function savestatus(){
		$status = I('get.status');
		$ids = I('post.id');
		if($status == 0){
			foreach ($ids as $id)
			{
				D('Addons://Links/Links')->off($id);
			}
			$this->success('成功启用该友情连接',Cookie('__forward__'));
		}else{
			foreach ($ids as $id)
			{
				D('Addons://Links/Links')->forbidden($id);
			}
			$this->success('成功禁用该友情连接',Cookie('__forward__'));
		}

	}
}
