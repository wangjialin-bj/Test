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
 * 后台频道控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */

class ChannelController extends AdminController {

    private $channelModelM = null;
    private $channelModelD = null;

    protected function _initialize(){
        parent::_initialize();
        $this->channelModelD = LANG_SET == 'en-us' ? D('ChannelEn') : D('Channel');
        $this->channelModelM = LANG_SET == 'en-us' ? M('ChannelEn') : M('Channel');
    }
    /**
     * 频道列表
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){
        $pid = i('get.pid', 0);
        /* 获取频道列表 */
        $map  = array('status' => array('gt', -1), 'pid'=>$pid);
        $list = $this->channelModelM->where($map)->order('sort asc,id asc')->select();

        $this->assign('list', $list);
        $this->assign('pid', $pid);
        $this->meta_title = L('L_ACTION_CHANNEL_1');
        $this->display();
    }

    /**
     * 添加频道
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function add(){
        if(IS_POST){
            $Channel = $this->channelModelD;
            $data = $Channel->create();
            if($data){
                $id = $Channel->add();
                if($id){
                    $this->success(L('L_ADD_SUCCESS'), U('index'));
                    //记录行为
                    action_log('update_channel', 'channel', $id, UID);
                } else {
                    $this->error(L('L_ADD_ERROR'));
                }
            } else {
                $this->error($Channel->getError());
            }
        } else {
            $pid = i('get.pid', 0);
            //获取父导航
            if(!empty($pid)){
                $parent = $this->channelModelM->where(array('id'=>$pid))->field('title')->find();
                $this->assign('parent', $parent);
            }

            $this->assign('pid', $pid);
            $this->assign('info',null);
            $this->meta_title = L('L_ACTION_CHANNEL_2');
            $this->display('edit');
        }
    }

    /**
     * 编辑频道
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function edit($id = 0){
        if(IS_POST){
            $Channel = $this->channelModelD;
            $data = $Channel->create();
            if($data){
                if($Channel->save()){
                    //记录行为
                    action_log('update_channel', 'channel', $data['id'], UID);
                    $this->success(L('L_EDIT_SUCCESS'), U('index'));
                } else {
                    $this->error(L('L_EDIT_ERROR'));
                }

            } else {
                $this->error($Channel->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = $this->channelModelM->find($id);

            if(false === $info){
                $this->error(L('L_LOADCONFIG_ERROR'));
            }

            $pid = i('get.pid', 0);
            //获取父导航
            if(!empty($pid)){
            	$parent = $channelModelM->where(array('id'=>$pid))->field('title')->find();
            	$this->assign('parent', $parent);
            }

            $this->assign('pid', $pid);
            $this->assign('info', $info);
            $this->meta_title = L('L_ACTION_CHANNEL_3');
            $this->display();
        }
    }

    /**
     * 删除频道
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function del(){
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {//'请选择要操作的数据!'
            $this->error(L('L_CHIOCE_DATA'));
        }

        $map = array('id' => array('in', $id) );
        if($this->channelModelM->where($map)->delete()){
            //记录行为
            action_log('update_channel', 'channel', $id, UID);
            $this->success(L('L_DEL_SUCCESS'));
        } else {
            $this->error(L('L_DEL_ERROR'));
        }
    }

    /**
     * 导航排序
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
            $list = $this->channelModelM->where($map)->field('id,title')->order('sort asc,id asc')->select();

            $this->assign('list', $list);
            $this->meta_title = L('L_ACTION_CHANNEL_4');
            $this->display();
        }elseif (IS_POST){
            $ids = I('post.ids');
            $ids = explode(',', $ids);
            foreach ($ids as $key=>$value){
                $res = $this->channelModelM->where(array('id'=>$value))->setField('sort', $key+1);
            }
            if($res !== false){
                $this->success(L('L_SORT_SUCCESS'));
            }else{
                $this->eorror(L('L_SORT_ERROR'));
            }
        }else{
            $this->error(L('L_ERROR_REQUEST'));
        }
    }
}
