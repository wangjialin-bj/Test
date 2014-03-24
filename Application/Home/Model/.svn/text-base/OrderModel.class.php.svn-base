<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Model;
use Think\Model;

/**
 * 文档基础模型
 */
class OrderModel extends Model{

    /* 自动验证规则 */
    protected $_validate = array(
        array('account', 'require', '金额不能为空', self::EXISTS_VALIDATE , 'regex', self::MODEL_BOTH),
    );
    /* 用户模型自动完成 */
    protected $_auto = array(
        array('uid','session',self::MODEL_INSERT,'function','user_auth.uid'),
        array('create_time', NOW_TIME ,self::MODEL_INSERT),
        array('status', 0, self::MODEL_INSERT),
        array('user_type', 1, self::MODEL_INSERT),
        array('currency','USD',self::MODEL_INSERT),
    );

    public function addOrder()
    {
        $info = $this->create(array('name'=>date('YmdHis').session('user_auth.uid')));
        $info['account'] = I('Post.account');

        if($this->add($info))
        {
            return ture;
        }
        else
        {
            /*log write*/
            return false;
        }
    }

}
