<?php
namespace Home\Model;

use Think\Model;

class CommentModel extends Model {
    // 自动完成
    protected $_auto = array(
        // 填充评论者名称
        array('commenter_name', 'fillName', 1, 'callback'),
        // 转义特殊字符
        array('content', 'filterSpecialChars', 3, 'function'),
        // 评论时间
        array('created_at', 'datetime', 1, 'function'),
        // 修改时间
        array('updated_at', 'datetime', 3, 'function'),
    );

    /**
     * 填充评论者名称
     * @return
     */
    protected function fillName() {
        if (isset($_SESSION['username'])) {
            // 用户登陆，则使用用户名
            return $_SESSION['username'];
        }

        return getIpLocation();
    }
}