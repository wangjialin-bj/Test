<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;

/**
 * 后台配置控制器
 * @author yangweijie <yangweijiester@gmail.com>
 */
class MenuController extends AdminController {

    private $menuModelD = NULL;
    private $menuModelM = NULL;

    private $menu_name = 'Menu';

    protected function _initialize(){
        parent::_initialize();
        $this->menuModelD = LANG_SET == 'en-us' ? D('MenuEn') : D('Menu');
        $this->menuModelM = LANG_SET == 'en-us' ? M('MenuEn') : M('Menu');

        $this->menu_name = LANG_SET == 'en-us' ? 'MenuEn' : 'Menu';
    }
    /**
     * 后台菜单首页
     * @return none
     */
    public function index(){
        $pid  = I('get.pid',0);
        if($pid){
            $data = $this->menuModelM->where("id={$pid}")->field(true)->find();
            $this->assign('data',$data);
        }
        $title      =   trim(I('get.title'));
        $type       =   C('CONFIG_GROUP_LIST');
        $all_menu   =   $this->menuModelM->getField('id,title');
        $map['pid'] =   $pid;
        if($title)
            $map['title'] = array('like',"%{$title}%");
        $list       =   $this->menuModelM->where($map)->field(true)->order('sort asc,id asc')->select();
        int_to_string($list,array('hide'=>array(1=>'是',0=>'否'),'is_dev'=>array(1=>'是',0=>'否')));
        if($list) {
            foreach($list as &$key){
                if($key['pid']){
                    $key['up_title'] = $all_menu[$key['pid']];
                }
            }
            $this->assign('list',$list);
        }
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);

        $this->meta_title = L('L_ACTION_MENU_1');
        $this->display();
    }

    /**
     * 新增菜单
     * @author yangweijie <yangweijiester@gmail.com>
     */
    public function add(){
        if(IS_POST){
            $Menu = $this->menuModelD;
            $data = $Menu->create();
            if($data){
                $id = $Menu->add();
                if($id){
                    // S('DB_CONFIG_DATA',null);
                    //记录行为
                    action_log('update_menu', 'Menu', $id, UID);
                    $this->success(L('L_ADD_SUCCESS'), Cookie('__forward__'));
                } else {
                    $this->error(L('L_ADD_ERROR'));
                }
            } else {
                $this->error($Menu->getError());
            }
        } else {
            $this->assign('info',array('pid'=>I('pid')));
            $menus = $this->menuModelM->field(true)->select();
            $menus = D('Common/Tree')->toFormatTree($menus);
            $menus = array_merge(array(0=>array('id'=>0,'title_show'=>L('L_ACTION_MENU_2'))), $menus);
            $this->assign('Menus', $menus);
            $this->meta_title = L('L_ACTION_MENU_3');
            $this->display('edit');
        }
    }

    /**
     * 编辑配置
     * @author yangweijie <yangweijiester@gmail.com>
     */
    public function edit($id = 0){
        if(IS_POST){
            $Menu = $this->menuModelD;
            $data = $Menu->create();
            if($data){
                if($Menu->save()!== false){
                    // S('DB_CONFIG_DATA',null);
                    //记录行为
                    action_log('update_menu', 'Menu', $data['id'], UID);
                    $this->success(L('L_SAVE_SUCCESS'), Cookie('__forward__'));
                } else {
                    $this->error(L('L_SAVE_ERROR'));
                }
            } else {
                $this->error($Menu->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = $this->menuModelM->field(true)->find($id);
            $menus = $this->menuModelM->field(true)->select();
            $menus = D('Common/Tree')->toFormatTree($menus);

            $menus = array_merge(array(0=>array('id'=>0,'title_show'=>L('L_ACTION_MENU_4'))), $menus);
            $this->assign('Menus', $menus);
            if(false === $info){
                $this->error(L('L_ACTION_MENU_5'));
            }
            $this->assign('info', $info);
            $this->meta_title = L('L_ACTION_MENU_6');
            $this->display();
        }
    }

    /**
     * 删除后台菜单
     * @author yangweijie <yangweijiester@gmail.com>
     */
    public function del(){
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {
            $this->error(L('L_ACTION_MENU_7'));
        }

        $map = array('id' => array('in', $id) );
        if($this->menuModelM->where($map)->delete()){
            // S('DB_CONFIG_DATA',null);
            //记录行为
            action_log('update_menu', 'Menu', $id, UID);
            $this->success(L('L_DEL_SUCCESS'));
        } else {
            $this->error(L('L_DEL_ERROR'));
        }
    }

    public function toogleHide($id,$value = 1){
        $this->editRow($this->menu_name, array('hide'=>$value), array('id'=>$id));
    }

    public function toogleDev($id,$value = 1){
        $this->editRow($this->menu_name, array('is_dev'=>$value), array('id'=>$id));
    }

    public function importFile($tree = null, $pid=0){
        if($tree == null){
            $file = APP_PATH."Admin/Conf/Menu.php";
            $tree = require_once($file);
        }
        $menuModel = $this->menuModelD;
        foreach ($tree as $value) {
            $add_pid = $menuModel->add(
                array(
                    'title'=>$value['title'],
                    'url'=>$value['url'],
                    'pid'=>$pid,
                    'hide'=>isset($value['hide'])? (int)$value['hide'] : 0,
                    'tip'=>isset($value['tip'])? $value['tip'] : '',
                    'group'=>$value['group'],
                )
            );
            if($value['operator']){
                $this->import($value['operator'], $add_pid);
            }
        }
    }

    public function import(){
        if(IS_POST){
            $tree = I('post.tree');
            $lists = explode(PHP_EOL, $tree);
            $menuModel = $this->menuModelM;
            if($lists == array()){
                $this->error(L('L_ACTION_MENU_8'));
            }else{
                $pid = I('post.pid');
                foreach ($lists as $key => $value) {
                    $record = explode('|', $value);
                    if(count($record) == 2){
                        $menuModel->add(array(
                            'title'=>$record[0],
                            'url'=>$record[1],
                            'pid'=>$pid,
                            'sort'=>0,
                            'hide'=>0,
                            'tip'=>'',
                            'is_dev'=>0,
                            'group'=>'',
                        ));
                    }
                }
                $this->success(L('L_ACTION_MENU_9'),U('index?pid='.$pid));
            }
        }else{
            $this->meta_title = L('L_ACTION_MENU_10');
            $pid = (int)I('get.pid');
            $this->assign('pid', $pid);
            $data = $this->menuModelM->where("id={$pid}")->field(true)->find();
            $this->assign('data', $data);
            $this->display();
        }
    }

    /**
     * 菜单排序
     * @author huajie <banhuajie@163.com>
     */
    public function sort(){
        if(IS_GET){
            $ids = I('get.ids');
            $pid = I('get.pid');

            //获取排序的数据
            $map = array('status'=>array('gt',-1));
            if(!empty($ids)){
                $map['id'] = array('in',$ids);
            }else{
                if($pid !== ''){
                    $map['pid'] = $pid;
                }
            }
            $list = $this->menuModelM->where($map)->field('id,title')->order('sort asc,id asc')->select();

            $this->assign('list', $list);
            $this->meta_title = L('L_ACTION_MENU_11');
            $this->display();
        }elseif (IS_POST){
            $ids = I('post.ids');
            $ids = explode(',', $ids);
            foreach ($ids as $key=>$value){
                $res = $this->menuModelM->where(array('id'=>$value))->setField('sort', $key+1);
            }
            if($res !== false){
                $this->success(L('L_ACTION_MENU_12'));
            }else{
                $this->eorror(L('L_ACTION_MENU_13'));
            }
        }else{
            $this->error(L('L_ERROR_REQUEST'));
        }
    }
}
