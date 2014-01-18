<?php
namespace Home\Model;

use Think\Model\RelationModel;

/**
* user关联模型
*/
class AdminModel extends RelationModel {
    // 批量验证
    protected $patchValidate = true;

    // 关联
    protected $_link = array(
        // 一个管理员有多个处理订单
        'orders' => array(
            'mapping_type' => HAS_MANY,
            'class_name' => 'order',
            'foregin_key' => 'admin_id',
        ),
    );

    // 自动验证
    // array(验证字段, 验证规则, 错误信息, 验证条件, 附加规则, 验证时间)
    protected $_validate = array(
        // 账号为空验证
        array('admin_name', 'require', '账号不能为空！', 1, 'regex', 1),
        // 账号长度验证
        array('admin_name', '6, 24', '账号长度只能在6~24个字符之间！',
              1, 'length', 1),
        // 账号只能包含数字和字母
        array('admin_name', 'validNumLetter', '账号只能是数字和字母组成！', 1, 
              'callback', 1),
        // 账号唯一验证
        array('admin_name', '', '账号已经存在！', 1, 'unique', 1),
        // 密码为空验证，新增时才验证
        array('password', 'require', '用户密码不能为空！', 1, 'require',
              1, 'regex', 3),
        // 密码长度验证
        array('password', '6, 24', '用户密码长度只能在6~24个字符之间！',
              1, 'length', 3),
        // 密码名只能包含数字和字母
        array('password', 'validNumLetter', '密码只能是数字和字母组成！', 1, 
              'callback', 3),
        // 管理员等级
        array('rank', array('1', '2', '3'), '管理员账号只有撒三个等级！',
              2, 'in', 3),
    );

    // 自动完成
    // array(完成字段, 完成规则, 完成时间, 附加规则)
    protected $_auto = array(
        // 生成uuid
        array('uuid', 'uuid', 1, 'function'),
        // 注册时间
        array('created_at', 'datetime', 1, 'function'),
        // 修改时间
        array('updated_at', 'datetime', 3, 'function'),
        // 最后登陆时间
        array('latest_login_at', 'datetime', 1, 'function'),
        // 转义特殊字符
        array('admin_name', 'filterSpecialChars', 3, 'function'),
        array('password', 'filterSpecialChars', 3, 'function'),
        // 密码md5
        array('password', 'md5', 3, 'function'),
    );

    /**
     * 正则验证只能有数字和字母
     * @param  string $src 
     * @return boolean      
     */
    protected function validNumLetter($src) {
        $partten = '/^[a-zA-Z0-9]+$/';
        if (preg_match($partten, $src)) {
            return true;    
        }

        return false;
    }
}
