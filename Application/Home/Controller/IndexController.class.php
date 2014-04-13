<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;
use Think\Cache;
use Think\Extend;
/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {

	//系统首页
    public function index(){
        $this->assign('guide' , '网站首页');
		$category = D('Category')->getTree();
        $lists    = D('Document')->lists(null);

        $this->assign('category',$category);//栏目
        $this->assign('lists',$lists);//列表
        $this->assign('page',D('Document')->page);//分页
        $this->display();
    }

	public function details()
	{
		$this->display();
	}

    //语言切换
    public function changeLanguage()
    {
        $lang_type = I('Post.lang');
        if($lang_type)
        {
            if($lang_type == 'zh-cn' || $lang_type == 'en-us')
            {
                cookie('think_language',$lang_type,3600*100);
                echo 1;die;
            }
            echo 0;die;
        }
        echo 0;die;
    }
	public function help()
	{
        $this->assign('guide' , '网站帮助');
        $type = '';
        if($_GET['type'])
        {
            $type = trim($_GET['type']);
        }
        if($_GET['type'] == 'success')
        {
            dump($_REQUEST);
        }
        $this->assign("action" , $type);
        $this->assign("type",$type);
		$this->assign("nav" ,'help');
		$this->display();
	}
    /*测试发送邮件*/
    public function sendmail()
    {
        $this->checkUserLogin();
        $result = true;
        // $body = '<div style="width:400px;height:300px;background:#eee;margin:0 auto;">
        // <a href="www.baidu.com">很好很强大的密码找回</a></div>';
        // $result = send_mail("dz5362@163.com",'密码找回',$body,'wangjialin');
        if($result)
        {
            \Think\Log::write('uid:'.is_login().'发送邮件成功!','WARN');
        }
    }

    /*测试添加添加反馈*/
    public function addFeedback()
    {
        if(IS_POST){
            if(!is_login())
            {
                echo 2;die;
            }
            // if(!$this->checkEmail(I('Post.email'))) dump($this->checkEmail(I('Post.email')));die;
            if(D('Feedback')->addFeed())
            {
                echo 1;die;
            }else{
                echo 0;die;
            }
        }
        else
        {
            echo 0;die;
        }
    }

}