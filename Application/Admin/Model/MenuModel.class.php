<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Model;

/**
 * 插件模型
 * @author yangweijie <yangweijiester@gmail.com>
 */

class MenuModel extends Model {

	protected $_validate = array();

	 //初始化方法
    protected function _initialize()
    {
        parent::_initialize();
        $this->_validate = array(
        	array('title', 'require', L('L_MODEL_MENU_1'), self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
           	array('url','require',L('L_MODEL_MENU_2')), //默认情况下用正则进行验证
		);
    }

	//获取树的根到子节点的路径
	public function getPath($id){
		$path = array();
		$nav = $this->where("id={$id}")->field('id,pid,title')->find();
		$path[] = $nav;
		if($nav['pid'] >1){
			$path = array_merge($this->getPath($nav['pid']),$path);
		}
		return $path;
	}
}