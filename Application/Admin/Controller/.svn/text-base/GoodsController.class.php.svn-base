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
 * 后台商品控制器
 * @author dz5362 <dz5362@qq.com>
 */
class GoodsController extends AdminController {

    public function goodslist()
    {
        //$nickname       =   I('nickname');

        /* 获取要编辑的扩展模型模板 */
        $model      =   get_document_model($data['model_id']);
        $this->assign('model',      $model);

        //获取表单字段排序
        $fields = get_model_attribute($model['id']);
        $this->assign('fields',     $fields);
        $map['status']  =   array('egt',0);
        // if(is_numeric($nickname)){
        //     $map['uid|nickname']=   array(intval($nickname),array('like','%'.$nickname.'%'),'_multi'=>true);
        // }else{
        //     $map['nickname']    =   array('like', '%'.(string)$nickname.'%');
        // }

        $list   = $this->lists('Goods', $map);
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = '商品列表';
        $this->display();
    }

    public function addNewGoods()
    {

        $this->display();
    }
}