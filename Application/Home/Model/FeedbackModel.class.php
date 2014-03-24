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
class FeedbackModel extends Model{

    /* 用户模型自动完成 */
    protected $_auto = array(
        array('uid','session',self::MODEL_INSERT,'function','user_auth.uid'),
        array('ctime', NOW_TIME ,self::MODEL_INSERT),
        array('status', 0, self::MODEL_INSERT),
        array('is_del', 0, self::MODEL_INSERT),
        array('reply', '', self::MODEL_INSERT),
    );

    public function addFeed()
    {
        $info = $this->create();
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
