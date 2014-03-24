<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Model;

/**
 * 行为模型
 * @author huajie <banhuajie@163.com>
 */

class ActionModel extends Model {

    /* 自动验证规则 */
    protected $_validate = array();

    /* 自动完成规则 */
    protected $_auto = array(
        array('status', 1, self::MODEL_INSERT, 'string'),
        array('update_time', 'time', self::MODEL_BOTH, 'function'),
    );

    protected function _initialize()
    {
        parent::_initialize();
        $this->_validate =array(
            array('name', 'require', L('L_MODEL_ACTION_1'), self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
            array('name', '/^[a-zA-Z]\w{0,39}$/', L('L_MODEL_ACTION_2'), self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
            array('name', '', L('L_MODEL_ACTION_3'), self::MUST_VALIDATE, 'unique', self::MODEL_BOTH),
            array('title', 'require', L('L_MODEL_ACTION_4'), self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
            array('title', '1,80', L('L_MODEL_ACTION_5'), self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
            array('remark', 'require', L('L_MODEL_ACTION_6'), self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
            array('remark', '1,140', L('L_MODEL_ACTION_7'), self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
        );
    }
    /**
     * 新增或更新一个行为
     * @return boolean fasle 失败 ， int  成功 返回完整的数据
     * @author huajie <banhuajie@163.com>
     */
    public function update(){
        /* 获取数据对象 */
        $data = $this->create($_POST);
        if(empty($data)){
            return false;
        }

        /* 添加或新增行为 */
        if(empty($data['id'])){ //新增数据
            $id = $this->add(); //添加行为
            if(!$id){
                $this->error = L('L_MODEL_ACTION_8');
                return false;
            }
        } else { //更新数据
            $status = $this->save(); //更新基础内容
            if(false === $status){
                $this->error = L('L_MODEL_ACTION_9');
                return false;
            }
        }
        //删除缓存
        S('action_list', null);

        //内容添加或更新完成
        return $data;

    }

}
