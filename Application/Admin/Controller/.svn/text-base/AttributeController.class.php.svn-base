<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;

/**
 * 属性控制器
 * @author huajie <banhuajie@163.com>
 */
class AttributeController extends AdminController {

    /**
     * 属性列表
     * @author huajie <banhuajie@163.com>
     */
    public function index(){
        $model_id = I('get.model_id');
        /* 查询条件初始化 */
        $map['model_id']    =   $model_id;

        $list = $this->lists('Attribute', $map);
        int_to_string($list);

        // 记录当前列表页的cookie
        Cookie('__forward__',       $_SERVER['REQUEST_URI']);
        $this->assign('_list',      $list);
        $this->assign('model_id',   $model_id);
        $this->meta_title = L('L_ACTION_META_6');
        $this->display();
    }

    /**
     * 新增页面初始化
     * @author huajie <banhuajie@163.com>
     */
    public function add(){
        $model_id   =   I('get.model_id');
        $model      =   M('Model')->field('title,name,field_group')->find($model_id);
        $this->assign('model',$model);
        $this->assign('info', array('model_id'=>$model_id));
        $this->meta_title = L('L_ACTION_META_7');
        $this->display('edit');
    }

    /**
     * 编辑页面初始化
     * @author huajie <banhuajie@163.com>
     */
    public function edit(){
        $id = I('get.id','');
        if(empty($id)){
            $this->error(L('L_ACTION_ATTR_1'));
        }

        /*获取一条记录的详细数据*/
        $Model = M('Attribute');
        $data = $Model->field(true)->find($id);
        if(!$data){
            $this->error($Model->getError());
        }
        $model  =   M('Model')->field('title,name,field_group')->find($data['model_id']);
        $this->assign('model',$model);
        $this->assign('info', $data);
        $this->meta_title = L('L_ACTION_META_8');
        $this->display();
    }

    /**
     * 更新一条数据
     * @author huajie <banhuajie@163.com>
     */
    public function update(){
        $res = D('Attribute')->update();
        if(!$res){
            $this->error(D('Attribute')->getError());
        }else{
            $this->success($res['id']?L('L_SAVE_SUCCESS'):L('L_ADD_SUCCESS'), Cookie('__forward__'));
        }
    }

    /**
     * 删除一条数据
     * @author huajie <banhuajie@163.com>
     */
    public function remove(){
        $id = I('id');
        empty($id) && $this->error(L('L_PARAMETER_ERROR'));

        $Model = D('Attribute');

        $info = $Model->getById($id);
        empty($info) && $this->error(L('L_ACTION_ATTR_2'));

        //删除属性数据
        $res = $Model->delete($id);

        //删除表字段
        $Model->deleteField($info);
        if(!$res){
            $this->error(D('Attribute')->getError());
        }else{
            //记录行为
            action_log('update_attribute', 'attribute', $id, UID);
            $this->success(L('L_DEL_SUCCESS'), U('index','model_id='.$info['model_id']));
        }
    }
}
