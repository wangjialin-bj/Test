<?php
namespace Home\Model;
use Think\Model;

/**
 * 私信基础模型
 */
class MessageModel extends Model{

    private $uid;
    private $from_uid;
    private $content;

    /* 自动验证规则 */
    protected $_validate = array();
    
    /* 用户模型自动完成 */
    protected $_auto = array(
        // array('uid','session',self::MODEL_INSERT,'function','user_auth.uid'),
        array('mtime', NOW_TIME ,self::MODEL_INSERT),
        array('is_del', 0, self::MODEL_INSERT),
        array('is_read', 0, self::MODEL_INSERT)
    );

    public function sendMessage()
    {
        
    }

    //根据uid和类型获取message
    public function getMessageList($type = 0 , $uid )
    {
        if(!$uid)
        {
            return false;
        }
        $where['is_read'] = $type;
        $where['uid'] = $uid;
        $where['is_del'] = 0;
        $result = $this->where($where)
                        ->order('mtime desc')
                        ->select();
        if($result)
        {
            return $result;
        }
        else
        {
            return fasle;
        }
    }

    public function getUnReadCount($uid)
    {
        return $this->where('uid='.$uid.' and is_read=0')->count();
    }
}
