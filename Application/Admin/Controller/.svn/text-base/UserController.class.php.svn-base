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
 * 后台用户控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class UserController extends AdminController {

    /**
     * 用户管理首页
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){
        $nickname       =   I('nickname');
        $map['status']  =   array('egt',0);
        if(is_numeric($nickname)){
            $map['uid|nickname']=   array(intval($nickname),array('like','%'.$nickname.'%'),'_multi'=>true);
        }else{
            $map['nickname']    =   array('like', '%'.(string)$nickname.'%');
        }

        $list   = $this->lists('Member', $map);
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = L('L_ACTION_USER_1');
        $this->display();
    }

    /*显示反馈列表*/
    public function feedback()
    {
        $map['is_del'] = 0;
        $list = $this->lists('Feedback' ,$map);
        // dump($re);
        // $list = D('Feedback')->_list();
        foreach($list as $k => $v)
        {
            $list[$k]['ctime'] = date('Y-m-d H:i:s' , $v['ctime']);
            $list[$k]['username'] = get_username($v['uid']);
            $list[$k]['content'] = msubstr($v['content'] , 0 , 30);
            $list[$k]['status'] = $v['status'] == 0 ? L('L_ACTION_USER_2') : L('L_ACTION_USER_3');
        }
        $this->assign('_list', $list);
        $this->meta_title = L('L_ACTION_USER_4');
        $this->display();
    }

    /*显示邮件回复反馈界面*/
    public function feedbackReply()
    {
        $feedback_id = I('Get.feedback_id');
        if($feedback_id)
        {
            $data = D('Feedback')->getFeedbackInfoById($feedback_id);
        }
        if(IS_POST)
        {
            $reply = I('Post.reply');
            $email = I('Post.email');
            $feedback_id = I('Post.feedback_id');
            $uid = I('Post.uid');
            /* 检测密码 */
            if(empty($reply)){
                $this->error(L('L_ACTION_USER_5'));
            }
            if(!$email || !$feedback_id)
            {
                $this->error(L('L_ACTION_USER_6'));
            }
            //发送邮件
            $return  = send_mail($email ,L('L_ACTION_USER_7'),$reply ,get_username($uid));
            if($return)
            {
                $map['reply'] = $reply;
                $map['status'] = 1;
                $result = D('Feedback')->saveEmailInfo($feedback_id , $map);
                if(!$result)
                {
                    $data = array(
                        'feedback_id' => $feedback_id ,
                        'uid'         => UID,
                        'reply'       => $reply
                        );
                    \Think\Log::write(json_encode($data),'error');
                }
                $this->success(L('L_ACTION_USER_8'),U('feedback'));
            }
            else
            {
                \Think\Log::write(json_encode($return));
                $this->error(L('L_ACTION_USER_9').$return);
            }
        }
        $this->assign('_data' , $data);
        $this->meta_title = L('L_ACTION_USER_10');
        $this->display();
    }

    /**
    * 删除反馈信息
    */
    public function delFeedback()
    {
        $feedback_id = I('Get.feedback_id');
        if($$feedback_id)
        {
            $this->error(L('L_ACTION_USER_11') , U('feedback'));
        }
        $map['feedback_id'] = $feedback_id;
        $data['is_del'] = 9;//假删除
        $result = M('Feedback')->where($map)->save($data);
        if(!$result)
        {
            $this->error(L('L_DEL_ERROR') , U('feedback'));
        }
        $this->success(L('L_ACTION_USER_12'),U('feedback'));
    }
    /**
     * 修改昵称初始化
     * @author huajie <banhuajie@163.com>
     */
    public function updateNickname(){
        $nickname = M('Member')->getFieldByUid(UID, 'nickname');
        $this->assign('nickname', $nickname);
        $this->meta_title = L('L_ACTION_USER_13');
        $this->display();
    }

    /**
     * 修改昵称提交
     * @author huajie <banhuajie@163.com>
     */
    public function submitNickname(){
        //获取参数
        $nickname = I('post.nickname');
        $password = I('post.password');
        empty($nickname) && $this->error(L('L_ACTION_USER_14'));
        empty($password) && $this->error(L('L_ACTION_USER_15'));

        //密码验证
        $User   =   new UserApi();
        $uid    =   $User->login(UID, $password, 4);
        ($uid == -2) && $this->error(L('L_ACTION_USER_16'));

        $Member =   D('Member');
        $data   =   $Member->create(array('nickname'=>$nickname));
        if(!$data){
            $this->error($Member->getError());
        }

        $res = $Member->where(array('uid'=>$uid))->save($data);

        if($res){
            $user               =   session('user_auth');
            $user['username']   =   $data['nickname'];
            session('user_auth', $user);
            session('user_auth_sign', data_auth_sign($user));
            $this->success(L('L_ACTION_USER_17'));
        }else{
            $this->error(L('L_ACTION_USER_18'));
        }
    }

    /**
     * 修改密码初始化
     * @author huajie <banhuajie@163.com>
     */
    public function updatePassword(){
        $this->meta_title = L('L_ACTION_USER_19');
        $this->display();
    }

    /**
     * 修改密码提交
     * @author huajie <banhuajie@163.com>
     */
    public function submitPassword(){
        //获取参数
        $password   =   I('post.old');
        empty($password) && $this->error(L('L_SUBMIT_PWD1'));
        $data['password'] = I('post.password');
        empty($data['password']) && $this->error(L('L_SUBMIT_PWD2'));
        $repassword = I('post.repassword');
        empty($repassword) && $this->error(L('L_SUBMIT_PWD3'));

        if($data['password'] !== $repassword){
            $this->error(L('L_SUBMIT_PWD4'));
        }

        $Api    =   new UserApi();
        $res    =   $Api->updateInfo(UID, $password, $data);
        if($res['status']){
            $this->success(L('L_SUBMIT_PWD5'));
        }else{
            $this->error($res['info']);
        }
    }

    /**
     * 用户行为列表
     * @author huajie <banhuajie@163.com>
     */
    public function action(){
        //获取列表数据
        $Action =   M('Action')->where(array('status'=>array('gt',-1)));
        $list   =   $this->lists($Action);
        int_to_string($list);
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);

        $this->assign('_list', $list);
        $this->meta_title = L('L_ACTION_USER_20');
        $this->display();
    }

    /**
     * 新增行为
     * @author huajie <banhuajie@163.com>
     */
    public function addAction(){
        $this->meta_title = L('L_ACTION_USER_21');
        $this->assign('data',null);
        $this->display('editaction');
    }

    /**
     * 编辑行为
     * @author huajie <banhuajie@163.com>
     */
    public function editAction(){
        $id = I('get.id');
        empty($id) && $this->error(L('L_ACTION_USER_22'));
        $data = M('Action')->field(true)->find($id);

        $this->assign('data',$data);
        $this->meta_title = L('L_ACTION_USER_23');
        $this->display();
    }

    /**
     * 更新行为
     * @author huajie <banhuajie@163.com>
     */
    public function saveAction(){
        $res = D('Action')->update();
        if(!$res){
            $this->error(D('Action')->getError());
        }else{
            $this->success($res['id']? L('L_SAVE_SUCCESS'):L('L_ADD_SUCCESS'), Cookie('__forward__'));
        }
    }

    /*
    * 反馈状态修改
    */
    public function changeFeedbackStatus($method = null)
    {
        $id = array_unique((array)I('id',0));
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error(L('L_ACTION_USER_24'));
        }
        $map['feedback_id'] =   array('in',$id);
        switch ( strtolower($method) ){
            case 'deletefeedback':
                $this->delete('Feedback', $map );
                break;
            default:
                $this->error(L(L('L_ACTION_USER_25')));
        }
    }

    /**
     * 会员状态修改
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        if( in_array(C('USER_ADMINISTRATOR'), $id)){
            $this->error(L('L_ACTION_USER_26'));
        }
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error(L('L_ACTION_USER_26'));
        }
        $map['uid'] =   array('in',$id);
        switch ( strtolower($method) ){
            case 'forbiduser':
                $this->forbid('Member', $map );
                break;
            case 'resumeuser':
                $this->resume('Member', $map );
                break;
            case 'deleteuser':
                $this->delete('Member', $map );
                break;
            default:
                $this->error(L('L_ACTION_AUTH_3'));
        }
    }

    public function add($username = '', $password = '', $repassword = '', $email = ''){
        if(IS_POST){
            /* 检测密码 */
            if($password != $repassword){
                $this->error(L('L_ACTION_USER_27'));
            }

            /* 调用注册接口注册用户 */
            $User   =   new UserApi;
            $uid    =   $User->register($username, $password, $email);
            if(0 < $uid){ //注册成功
                $user = array('uid' => $uid, 'nickname' => $username, 'status' => 1);
                if(!M('Member')->add($user)){
                    $this->error(L('L_ACTION_USER_28'));
                } else {
                    $this->success(L('L_ACTION_USER_29'),U('index'));
                }
            } else { //注册失败，显示错误信息
                $this->error($this->showRegError($uid));
            }
        } else {
            $this->meta_title = L('L_ACTION_USER_30');
            $this->display();
        }
    }

    /**
     * 获取用户注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0){
        switch ($code) {
            case -1:  $error = L('L_ACTION_USER_31'); break;
            case -2:  $error = L('L_ACTION_USER_32'); break;
            case -3:  $error = L('L_ACTION_USER_33'); break;
            case -4:  $error = L('L_ACTION_USER_34'); break;
            case -5:  $error = L('L_ACTION_USER_35'); break;
            case -6:  $error = L('L_ACTION_USER_36'); break;
            case -7:  $error = L('L_ACTION_USER_37'); break;
            case -8:  $error = L('L_ACTION_USER_38'); break;
            case -9:  $error = L('L_ACTION_USER_39'); break;
            case -10: $error = L('L_ACTION_USER_40'); break;
            case -11: $error = L('L_ACTION_USER_41'); break;
            default:  $error = L('L_ACTION_USER_42');
        }
        return $error;
    }

}
