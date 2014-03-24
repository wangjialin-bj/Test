<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return array(
    /*开启多语言支持*/
    'LANG_SWITCH_ON'        => true,   // 默认关闭语言包功能
    'LANG_AUTO_DETECT'      => true,   // 自动侦测语言 开启多语言功能后有效
    'LANG_LIST'             => 'zh-cn,en-us', // 允许切换的语言列表 用逗号分隔

    /* 模块相关配置 */
    'AUTOLOAD_NAMESPACE' => array('Addons' => ONETHINK_ADDON_PATH), //扩展模块列表
    'DEFAULT_MODULE'     => 'Home',
    'MODULE_DENY_LIST'   => array('Common', 'User'),
    //'MODULE_ALLOW_LIST'  => array('Home','Admin'),

    /* 系统数据加密设置 */
    'DATA_AUTH_KEY' => 'H^@)Ob!cy:pCQr$`xf6?Pmkt4BaYv0#]-V,i"J2%', //默认数据加密KEY

    /* 调试配置 */
    'SHOW_PAGE_TRACE' => true,

    /* 用户相关设置 */
    'USER_MAX_CACHE'     => 1000, //最大缓存用户数
    'USER_ADMINISTRATOR' => 1, //管理员用户ID

    /* URL配置 */
    'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            => 1, //URL模式
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符

    /* 全局过滤配置 */
    'DEFAULT_FILTER' => '', //全局过滤函数

    /* 数据库配置 */
    'DB_TYPE'   => 'mysqli', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'onethinkv1', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '687091',  // 密码
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => 'db_', // 数据库表前缀

    /* 文档模型配置 (文档模型核心配置，请勿更改) */
    'DOCUMENT_MODEL_TYPE' => array(2 => '主题', 1 => '目录', 3 => '段落'),

	/*邮件设置*/
	'MAIL_SMTP_HOST' => 'smtp.qq.com',	//发送服务器地址
	'MAIL_SMTP_PORT' => 25,				//发送服务器地址
	'MAIL_SMTP_USER' => 'dz5362@qq.com',//发送邮箱
	'MAIL_SMTP_PASS' => 'lai100yy0110',	//发送邮箱密码
	'MAIL_SMTP_CE'	 =>	'dz5362@163.com',//测试接收邮箱地址

    /*paypal支付配置*/
    'PAYPAL_FORM_CONFIG' =>  array(
        'cmd'       =>  '_xclick',
        'req_url'   =>  'https://www.paypal.com/cgi-bin/webscr',
        'business'  =>  'dz5362_3@qq.com',
        'item_name' =>  'OneThink',
        'invoice'   =>  0,
        'currency_code' => 'USD',
        'amount'    =>  0.01,
        'return'    =>  '',
        'notify_url'=>  '',
        ),
    /*日志操作*/
    'LOG_RECORD' => true, // 开启日志记录
    'LOG_LEVEL'  =>'EMERG,ALERT,CRIT,ERR', // 只记录EMERG ALERT CRIT ERR 错误
);
