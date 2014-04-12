<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use User\Api\UserApi;

/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class UserController extends HomeController {

    protected function _initialize()
    {
        parent::_initialize();
        $this->assign('guide' , 'usercenter');
    }

	/* 登录页面 */
	public function login($id = '', $password = '', $verify = ''){
		if(IS_POST){ //登录验证
			/* 检测验证码 */
			if(!check_verify($verify)){
				$this->error('Captcha input error!');
			}

			$uid = intval($this->checklogin($id, $password));
			if(0 < $uid){
				if($this->checkLogin($uid)){ //登录用户
					//TODO:跳转到登录前页面
					// $this->success('登录成功！',U('Home/Index/index'));
					$this->success("Login successful!",U('User/paymentAccount'),3);
				} else {
					$this->error();
				}

			} else { //登录失败
				switch($uid) {
					case -1: $error = 'The user does not exist or is disabled.'; break; //系统级别禁用
					case -2: $error = 'Password error!'; break;
					default: $error = 'Unknown error!'; break; // 0-接口参数错误（调试阶段使用）
				}
				$this->error($error);
			}

		} else { //显示登录表单
			$this->display();
		}
	}

	public function checkLogin($id , $password)
	{
		$userModel = D('Users');
		$map['id'] = trim($id);
		get_username();
		$user = $userModel->where($map)->find();
		if(is_array($user)){
			/* 验证用户密码 */
			if(md5($password) === $user['password']){
				$data = array(
					'id'              => $user['id'],
					'last_login_date' => date('y-m-d H:i:s' , time()),
					'last_login_ip'   => get_client_ip(0),
				);
				$userModel->where('id='.$user['id'])->save($data);
				//写入session
				$auth = array(
					'uid'             => $user['id'],
					'email'        => ($user['email']),
					'is_translator'   => $user['is_translator'],
					'last_login_date' => $user['last_login_date'],
				);

				session('user_auth', $auth);
				session('user_auth_sign', data_auth_sign($auth));
				return $user['id']; //登录成功，返回用户ID
			} else {
				return -2; //密码错误
			}
		} else {
			return -1; //用户不存在或被禁用
		}
	}

	/* 退出登录 */
	public function logout(){
		if(is_login()){
			D('Member')->logout();
			$this->success('退出成功！', U('User/login'));
		} else {
			$this->redirect('User/login');
		}
	}

	/* 验证码，用于登录和注册 */
	public function verify(){
		$verify = new \Think\Verify();
		$verify->entry(1);
	}

	/**
	 * 获取用户注册错误信息
	 * @param  integer $code 错误编码
	 * @return string        错误信息
	 */
	private function showRegError($code = 0){
		switch ($code) {
			case -1:  $error = '用户名长度必须在16个字符以内！'; break;
			case -2:  $error = '用户名被禁止注册！'; break;
			case -3:  $error = '用户名被占用！'; break;
			case -4:  $error = '密码长度必须在6-30个字符之间！'; break;
			case -5:  $error = '邮箱格式不正确！'; break;
			case -6:  $error = '邮箱长度必须在1-32个字符之间！'; break;
			case -7:  $error = '邮箱被禁止注册！'; break;
			case -8:  $error = '邮箱被占用！'; break;
			case -9:  $error = '手机格式不正确！'; break;
			case -10: $error = '手机被禁止注册！'; break;
			case -11: $error = '手机号被占用！'; break;
			default:  $error = '未知错误';
		}
		return $error;
	}


    /**
     * 修改密码提交
     * @author huajie <banhuajie@163.com>
     */
    public function profile(){
		if ( !is_login() ) {
			$this->error( '您还没有登陆',U('User/login') );
		}
        if ( IS_POST ) {
            //获取参数
            $uid        =   is_login();
            $password   =   I('post.old');
            $repassword = I('post.repassword');
            $data['password'] = I('post.password');
            empty($password) && $this->error('Please enter the original password');
            empty($data['password']) && $this->error('Please enter a new password');
            empty($repassword) && $this->error('Please enter the confirmation password');

            if($data['password'] !== $repassword){
                $this->error("You enter a new password and confirm password don't match");
            }
            $res = $this->updateInfo($uid, $password, $data);
            if($res['status']){
				$this->error('Success!' , 2 , U('Home/User/paymentAccount'));
            }else{
                $this->error('Error!');
            }
        }else{
            $this->display();
        }
    }

	public function updateInfo($uid, $password, $data){
		$usersModel = D('Users');
		if($this->updateUserFields($uid, $password, $data) !== false){
			$return['status'] = true;
		}else{
			$return['status'] = false;
			$return['info'] = $usersModel->getError();
		}
		return $return;
	}

	public function updateUserFields($uid, $password, $data){
		$usersModel = D('Users');
		if(empty($uid) || empty($password) || empty($data)){
			$this->error = 'parameter error';
			return false;
		}

		//更新前检查用户密码
		if(!$this->verifyUser($uid, $password)){
			$this->error = 'Validation error: the password is not correct!';
			return false;
		}

		//更新用户信息
		$data['password'] = md5($data['password']);
		if($data){
			return $usersModel->where(array('id'=>$uid))->save($data);
		}
		return false;
	}

	protected function verifyUser($uid, $password_in){
		$usersModel = D('Users');
		$password = $usersModel->getFieldById($uid, 'password');
		if(md5($password_in) === $password){
			return true;
		}
		return false;
	}

	/*
	 * 用户账户余额
	 * */
	public function paymentAccount()
	{
		$this->checkUserLogin();
		$uid = UID;
		$userModel =  D('Users');
		$result = $userModel->field('id , money')->where('id='.$uid)->find();

		if(!$result)
		{
			$this->redirect('Home/Index');
		}
		$result['id'] = (int)($result['id']);
		$result['money'] = (float)($result['money']);
		$this->assign('data' , $result);
		$this->assign('guide' , 'paymentAccount');
		$this->display();
	}

	/*
	 * 用户充值处理 paypal
	 * */
	public function deposit()
	{
		$this->checkUserLogin();

		$this->assign('guide' , 'paymentAccount');
		$this->display();
	}

	/*
	 * 用户充值记录
	 * */
	public function depositHistory()
	{
		$this->checkUserLogin();
		$uid = intval(UID);//uid
		$row = 10;
		$rechargeModel = D('RechargeLog');
		$field_arr = array('id' , 'uid' , 'payment_date' , 'mc_gross');
		$where = array('uid' => $uid);

		if(I('get.export') == 1)
		{
			$time = date('YmdHis').mt_rand(10000,99999);
			header("Content-type:application/vnd.ms-excel");
			$file_name = $time . 'Exploder.csv';
			header(file_name($file_name));
			//数据处理
			$str = "Date,Amount\n";
			$result = $rechargeModel->field($field_arr)->where($where)->limit('0,2000')->order('payment_date desc')->select();
			foreach($result as $key=>$val)
			{
				$date_str = strtotime($val['payment_date']);
				$str .=  date('m-d-Y' , $date_str) . "," . $val['mc_gross'] ."\n";
			}
			echo $str;
			die;
		}

		$count = $rechargeModel->where($where)->count();
		$Page       = new \Think\Page($count,$row);
		$result = $rechargeModel->field($field_arr)->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('payment_date desc')->select();
		$show       = $Page->show();
		foreach($result as $key=>$val)
		{
			$date_arr = explode(' ' , $val['payment_date']);
			$date_str = strtotime($val['payment_date']);
			$result[$key]['payment_date'] = date('m-d-Y' , $date_str);
		}
		$this->assign('page' , $show);
		$this->assign('data' , $result);
		$this->assign('guide' , 'depositHistory');
		$this->display();
	}

	/*
	 * 用户交易记录
	 * */
	public function paymentHistory()
	{
		$this->checkUserLogin();
		$row = 10;
		$msglogsModel = D('MsgLogs');
		$maps['helper_id'] = intval(UID);
		$maps['reply_id'] = array('gt' , 0);
		$field_arr = array('reply_id' , 'msg_price' , 'reply_date' , 'profit');
		$count = $msglogsModel->field($field_arr)->where($maps)->count();


		if(I('get.export') == 1)
		{
			$time = date('YmdHis').mt_rand(10000,99999);
			header("Content-type:application/vnd.ms-excel");
			$file_name = $time . 'Exploder.csv';
			header(file_name($file_name));
			//数据处理
			$str = "Date,Time,Translator,Amount\n";
			$result = $msglogsModel->field($field_arr)->where($maps)->limit('0 , 2000')->order('reply_date desc')->select();
			foreach($result as $key=>$val)
			{
				$date_arr = strtotime($val['reply_date']);
				$result[$key]['ymd'] = date('m-d-Y',$date_arr);
				$result[$key]['his'] = date('H:i:s_A',$date_arr);
				$result[$key]['price'] =(float)$val['msg_price']  -  ($val['profit'] != null ? (float)$val['profit'] : (float)'0.00');

				$str .= $result[$key]['ymd'] . ",". $result[$key]['his'] .",ID:".$result[$key]['reply_id'] .",".$result[$key]['price'] ."\n";
			}
			echo $str;
			die;
		}


		$Page       = new \Think\Page($count,$row);
		$result = $msglogsModel->field($field_arr)->where($maps)->limit($Page->firstRow.','.$Page->listRows)->order('reply_date desc')->select();
		$show       = $Page->show();
		$this->assign('page' , $show);

		foreach($result as $key=>$val)
		{
			$date_arr = strtotime($val['reply_date']);
			$result[$key]['ymd'] = date('m-d-Y',$date_arr);
			$result[$key]['his'] = date('H:i:s A',$date_arr);
			$result[$key]['price'] =(float)$val['msg_price']  -  ($val['profit'] != null ? (float)$val['profit'] : (float)'0.00');
		}


		$this->assign('data' , $result);
		$this->assign('guide' , 'paymentHistory');
		$this->display();
	}

	/*
	 * 议员收入账户余额
	 * */
	public function incomeAccount()
	{
		$this->checkUserLogin();
		$user_type = get_usertype();
		$uid = UID;
		$userModel =  D('TransUsers');
		$result = $userModel->field('id , money')->where('id='.$uid)->find();

		if(!$result)
		{
			$this->redirect('Home/Index');
		}
		$result['id'] = (int)($result['id']);
		$result['money'] = (float)($result['money']);
		$this->assign('data' , $result);
		$this->assign('user_type' , $user_type);
		$this->assign('guide' , 'incomeAccount');
		$this->display();
	}

	public function incomeHistory()
	{
		$this->checkUserLogin();
		$user_type = get_usertype();
		if($user_type == 1)
		{
			$row = 10;
			$msglogsModel = D('MsgLogs');
			$maps['reply_id'] = intval(UID);
			$maps['helper_id'] = array('gt' , 0);
			$field_arr = array('helper_id' , 'msg_price' , 'reply_date' , 'profit');
			$count = $msglogsModel->field($field_arr)->where($maps)->count();

			if(I('get.export') == 1)
			{
				$time = date('YmdHis').mt_rand(10000,99999);
				header("Content-type:application/vnd.ms-excel");
				$file_name = $time . 'Exploder.csv';
				header(file_name($file_name));
				//数据处理
				$str = "Date,Time,Requester,Amount\n";
				$result = $msglogsModel->field($field_arr)->where($maps)->limit('0 , 2000')->order('reply_date desc')->select();
				foreach($result as $key=>$val)
				{
					$date_arr = strtotime($val['reply_date']);
					$result[$key]['ymd'] = date('m-d-Y',$date_arr);
					$result[$key]['his'] = date('H:i:s_A',$date_arr);
					$result[$key]['price'] =(float)$val['msg_price']  -  ($val['profit'] != null ? (float)$val['profit'] : (float)'0.00');

					$str .= $result[$key]['ymd'] . ",". $result[$key]['his'] .",ID:".$result[$key]['helper_id'] .",".$result[$key]['price'] ."\n";
				}
				echo $str;
				die;
			}

			$Page       = new \Think\Page($count,$row);
			$result = $msglogsModel->field($field_arr)->where($maps)->limit($Page->firstRow.','.$Page->listRows)->order('reply_date desc')->select();
			$show       = $Page->show();
			$this->assign('page' , $show);

			foreach($result as $key=>$val)
			{
				$date_arr = strtotime($val['reply_date']);
				$result[$key]['ymd'] = date('m-d-Y',$date_arr);
				$result[$key]['his'] = date('H:i:s A',$date_arr);
				$result[$key]['price'] =(float)$val['msg_price']  -  ($val['profit'] != null ? (float)$val['profit'] : (float)'0.00');
			}

			$this->assign('data' , $result);
		}

		$this->assign('user_type' , $user_type);
		$this->assign('guide' , 'incomeHistory');
		$this->display();
	}

	public function withdrawsHistory()
	{
		$this->checkUserLogin();
		$msgLogs = D('MsgLogs')->query('select * from db_msg_logs a , db_trans_users b where 1 = 1 limit 0 , 2');
		dump($msgLogs);
		$user_type = get_usertype();
		$this->assign('user_type' , $user_type);
		$this->assign('guide' , 'withdrawsHistory');
		$this->display();
	}

}
