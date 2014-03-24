<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: dz5362 <dz5362@qq.com>
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Model;
/**
 * 配置模型
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */

class ConfigEnModel extends Model {

    protected $_validate = array();

    protected $_auto = array(
        array('name', 'strtoupper', self::MODEL_BOTH, 'function'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
        array('status', '1', self::MODEL_BOTH),
    );

    //初始化方法
    protected function _initialize()
    {
        parent::_initialize();
        $this->_validate =array(
            array('name', 'require', L('L_MODEL_CONFIG_1'), self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
            array('name', '', L('L_MODEL_CONFIG_2'), self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
            array('title', 'require', L('L_MODEL_CONFIG_3'), self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        );
    }

    /**
     * 获取配置列表
     * @return array 配置数组
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function lists(){
        $map    = array('status' => 1);
        $data   = $this->where($map)->field('type,name,value')->select();
        $config = array();
        if($data && is_array($data)){
            foreach ($data as $value) {
                $config[$value['name']] = $this->parse($value['type'], $value['value']);
            }
        }
        return $config;
    }

    /**
     * 根据配置类型解析配置
     * @param  integer $type  配置类型
     * @param  string  $value 配置值
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    private function parse($type, $value){
        switch ($type) {
            case 3: //解析数组
                $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
                if(strpos($value,':')){
                    $value  = array();
                    foreach ($array as $val) {
                        list($k, $v) = explode(':', $val);
                        $value[$k]   = $v;
                    }
                }else{
                    $value =    $array;
                }
                break;
        }
        return $value;
    }

}