<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com>
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Model;

/**
 * 导航模型
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */

class ChannelModel extends Model {
    protected $_validate = array();

    //初始化方法
    protected function _initialize()
    {
        parent::_initialize();
        $this->_validate =array(
            array('title', 'require', L('L_MODEL_CHANNEL_1'), self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
            array('url', 'require', L('L_MODEL_CHANNEL_2'), self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        );
    }

    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
        array('status', '1', self::MODEL_BOTH),
    );

}
