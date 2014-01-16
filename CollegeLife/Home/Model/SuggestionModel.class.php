<?php
namespace Home\Model;

use Think\Model;

class SuggestionModel extends Model {
	// 自动完成
    protected $_auto = array(
        // 转义特殊字符
    	array('real_name', 'filterSpecialChars', 3, 'function'),
        array('tel', 'filterSpecialChars', 3, 'function'),
    	array('content', 'filterSpecialChars', 3, 'function'),
        // 评论时间
        array('created_at', 'datetime', 1, 'function'),
        // 修改时间
        array('updated_at', 'datetime', 3, 'function'),
    );
}