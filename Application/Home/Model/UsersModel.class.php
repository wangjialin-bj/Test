<?php
// +----------------------------------------------------------------------
// +----------------------------------------------------------------------

namespace Home\Model;
use Think\Model;

/**
 *
 */

class UsersModel extends Model{

	protected $connection = 'DB_CONFIG_TATOR';


	/**
	 * 登录指定用户
	 * @param  integer $uid 用户ID
	 * @return boolean      ture-登录成功，false-登录失败
	 */
	public function login($uid){
		/* 检测是否在当前应用注册 */
		$user = $this->field(true)->find($uid);
		if(!$user){ //未注册
			return false;
		}

		/* 登录用户 */
		$this->autoLogin($user);

		//记录行为
		action_log('user_login', 'users', $uid, $uid);

		return true;
	}

	/**
	 * 注销当前用户
	 * @return void
	 */
	public function logout(){
		session('user_auth', null);
		session('user_auth_sign', null);
	}

	/**
	 * 自动登录用户
	 * @param  integer $user 用户信息数组
	 */
	private function autoLogin($user){
		/* 更新登录信息 */
		$data = array(
			'uid'             => $user['id'],
			'last_login_date' => date('y-m-d H:i:s' ,time()),
			'last_login_ip'   => get_client_ip(0),
		);
		$this->save($data);

		/* 记录登录SESSION和COOKIES */
		$auth = array(
			'uid'             => $user['id'],
			'email'        => ($user['email']),
			'is_translator'   => $user['is_translator'],
			'last_login_time' => $user['last_login_time'],
		);

		session('user_auth', $auth);
		session('user_auth_sign', data_auth_sign($auth));

	}
}
