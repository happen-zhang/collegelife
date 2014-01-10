<?php
namespace Home\Model;

use Think\Model;

/**
* user模型
*/
class UserModel extends Model {
    // 批量验证
    protected $patchValidate = true;

    // 自动验证
    // array(验证字段, 验证规则, 错误信息, 验证条件, 附加规则, 验证时间)
    protected $_validate = array(
        // 用户名为空验证
        array('username', 'require', '用户名不能为空！', 1, 'regex', 1),
        // 用户名长度验证
        array('username', '6, 24', '用户名长度只能在6~24个字符之间！',
              1, 'length', 1),
        // 用户名只能包含数字和字母
        array('username', 'validNumLetter', '用户名只能是数字和字母组成！', 1, 
              'callback', 1),
        // 用户名唯一验证
        array('username', '', '用户名已经存在！', 1, 'unique', 1),
        // 密码为空验证，新增时才验证
        array('password', 'require', '用户密码不能为空！', 1, 'require',
              1, 'regex', 3),
        // 密码长度验证
        array('password', '6, 24', '用户密码长度只能在6~24个字符之间！',
              1, 'length', 3),
        // 密码名只能包含数字和字母
        array('password', 'validNumLetter', '密码只能是数字和字母组成！', 1, 
              'callback', 3),
        // email为空验证
        array('email', 'require', '邮箱不能为空！', 1, 'regex', 3),
        // email格式验证
        array('email', 'email', '邮箱格式不正确！', 1, 'regex', 3),
        // email长度验证
        array('email', '6, 128', '邮箱长度只能在6~128个字符之间！', 1, 'length', 3),
        // email唯一验证，新增数据
        array('email', '', 'email已经存在！', 1, 'unique', 1),
        // email唯一验证，更新数据
        array('email', 'uniqueEmail', 'email已经存在！', 1, 'callback', 2),
        // 真实姓名长度验证，不为空时验证
        array('real_name', '2, 8', '真实姓名长度只能在2~8个字符之间！', 2, 
              'length', 3),
        // 真实姓名不能包含特殊字符，不为空时验证
        //array('real_name', 'unvalidSpecialChars', '真实姓名不能包含特殊字符！', 2, 
        //      'callback', 3),
        // 号码类型验证，不为空时验证
        array('tel_type', array('移动', '联通'), '号码类型只能为<移动>或者<联通>！',
              2, 'in', 3),
        // 长号数字验证 ，不为空时验证
        array('tel_full', 'number', '号码必须是数字！', 2, 'regex', 3),
        // 短号数字验证，不为空时验证
        array('tel_brief', 'number', '号码必须是数字！', 2, 'regex', 3),
        // 楼号数字验证，不为空时验证
        array('building_no', 'number', '楼号必须是数字！', 2, 'regex', 3),
        // 宿舍号数字验证，不为空时验证
        array('dormitory_no', 'number', '宿舍号必须是数字！', 2, 'regex', 3),
    );

    // 自动完成
    // array(完成字段, 完成规则, 完成时间, 附加规则)
    protected $_auto = array(
        // 生成uuid
        array('uuid', 'uuid', 1, 'function'),
        // 注册时间
        array('register_time', 'datetime', 1, 'callback'),
        // 转义特殊字符
        array('username', 'filterSpecialChars', 1, 'callback'),
        array('password', 'filterSpecialChars', 3, 'callback'),
        array('real_name', 'filterSpecialChars', 3, 'callback'),
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

    /**
     * 正则验证不包含特殊字符
     * @param  string $src
     * @return boolean
     */
    protected function unvalidSpecialChars($src) {
        $partten = "/^(([^\^\.<>%&',;=?$\"':#@!~\]\[{}\\/`\|])*)$/";
        if (!preg_match($partten, $src)) {
            return true;
        }

        return false;
    }

    /**
    * 生成datetime
    * @return string
    */
    protected function datetime() {
        return date('Y-m-d H:i:s');
    }

    /**
    * 过滤特殊字符
    * @param  string $src
    * @return string
    */
    protected function filterSpecialChars($src) {
        return sql_injection(htmlspecialchars($src));
    }

    /**
     * 验证email唯一
     * @return boolean
     */
    protected function uniqueEmail($email) {
        if (!isset($_SESSION['uid'])) {
            return false;
        }

        $User = M('User');
        $where['uuid'] = array('neq', $_SESSION['uid']);
        $where['email'] = array('eq', $email);
        if ($User->where($where)->find()) {
            // email已经存在
            return false;
        }

        return true;
    }
}