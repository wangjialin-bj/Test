<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;

/**
 * 后台配置控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class ConfigController extends AdminController {

    private $configModelM = null;
    private $configModelD = null;

    private $model_name = 'Config';

    protected function _initialize(){
        parent::_initialize();
        $this->configModelD = LANG_SET == 'en-us' ? D('ConfigEn') : D('Config');
        $this->configModelM = LANG_SET == 'en-us' ? M('ConfigEn') : M('Config');
        $this->model_name = LANG_SET == 'en-us' ? 'ConfigEn' : 'Config';
    }
    /**
     * 配置管理
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){
        /* 查询条件初始化 */
        $map = array();
        $map  = array('status' => 1);
        if(isset($_GET['group'])){
            $map['group']   =   I('group',0);
        }
        if(isset($_GET['name'])){
            $map['name']    =   array('like', '%'.(string)I('name').'%');
        }

        $list = $this->lists($this->model_name, $map,'sort,id');

        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->assign('group',C('CONFIG_GROUP_LIST'));
        $this->assign('group_id',I('get.group',0));
        $this->assign('list', $list);
        $this->meta_title = L('L_ACTION_CONFIG_1');
        $this->display();
    }

    /**
     * 新增配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function add(){
        if(IS_POST){
            $Config = $this->configModelD;
            $data = $Config->create();
            if($data){
                if($Config->add()){
                    S('DB_CONFIG_DATA',null);
                    $this->success(L('L_ADD_SUCCESS'), U('index'));
                } else {
                    $this->error(L('L_ADD_ERROR'));
                }
            } else {
                $this->error($Config->getError());
            }
        } else {
            $this->meta_title = L('L_ACTION_CONFIG_2');
            $this->assign('info',null);
            $this->display('edit');
        }
    }

    /**
     * 编辑配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function edit($id = 0){
        if(IS_POST){
            $Config = $this->configModelD;
            $data = $Config->create();
            if($data){
                if($Config->save()){
                    S('DB_CONFIG_DATA',null);
                    //记录行为
                    action_log('update_config','config',$data['id'],UID);
                    $this->success(L('L_SAVE_SUCCESS'), Cookie('__forward__'));
                } else {
                    $this->error(L('L_SAVE_ERROR'));
                }
            } else {
                $this->error($Config->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = $this->configModelM->field(true)->find($id);

            if(false === $info){
                $this->error(L('L_ACTION_CONFIG_3'));
            }
            $this->assign('info', $info);
            $this->meta_title = L('L_ACTION_CONFIG_4');
            $this->display();
        }
    }

    /**
     * 批量保存配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function save($config){
        if($config && is_array($config)){
            $Config = $this->configModelM;
            foreach ($config as $name => $value) {
                $map = array('name' => $name);
                $Config->where($map)->setField('value', $value);
            }
        }
        S('DB_CONFIG_DATA',null);
        $this->success(L('L_SAVE_SUCCESS'));
    }

    /**
     * 删除配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function del(){
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {
            $this->error(L('L_ACTION_CONFIG_5'));
        }

        $map = array('id' => array('in', $id) );
        if($this->configModelM->where($map)->delete()){
            S('DB_CONFIG_DATA',null);
            //记录行为
            action_log('update_config','config',$id,UID);
            $this->success(L('L_DEL_SUCCESS'));
        } else {
            $this->error(L('L_DEL_ERROR'));
        }
    }

    // 获取某个标签的配置参数
    public function group() {
        $id     =   I('get.id',1);
        $type   =   C('CONFIG_GROUP_LIST');
        $list   =   $this->configModelM->where(array('status'=>1,'group'=>$id))->field('id,name,title,extra,value,remark,type')->order('sort')->select();
        if($list) {
            $this->assign('list',$list);
        }
        $this->assign('id',$id);
        $this->meta_title = $type[$id].L('L_ACTION_CONFIG_6');
        $this->display();
    }

    /**
     * 配置排序
     * @author huajie <banhuajie@163.com>
     */
    public function sort(){
        if(IS_GET){
            $ids = I('get.ids');

            //获取排序的数据
            $map = array('status'=>array('gt',-1));
            if(!empty($ids)){
                $map['id'] = array('in',$ids);
            }elseif(I('group')){
                $map['group']	=	I('group');
            }
            $list = $this->configModelM->where($map)->field('id,title')->order('sort asc,id asc')->select();

            $this->assign('list', $list);
            $this->meta_title = L('L_ACTION_CONFIG_7');
            $this->display();
        }elseif (IS_POST){
            $ids = I('post.ids');
            $ids = explode(',', $ids);
            foreach ($ids as $key=>$value){
                $res = $this->configModelM->where(array('id'=>$value))->setField('sort', $key+1);
            }
            if($res !== false){
                $this->success(L('L_ACTION_CONFIG_8'),Cookie('__forward__'));
            }else{
                $this->eorror(L('L_ACTION_CONFIG_9'));
            }
        }else{
            $this->error(L('L_ERROR_REQUEST'));
        }
    }

    /*清理缓存*/
    public function  clearRuntime()
    {
        unlink_dir('./Runtime');
        $this->display();
    }
}
