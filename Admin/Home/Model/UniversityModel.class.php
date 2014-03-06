<?php
namespace Home\Model;

use Think\Model\RelationModel;

/**
 * University
 */
class UniversityModel extends RelationModel {
    // 关联模型
    protected $_link = array(

    );

    // 自动完成
    protected $_auto = array(
        array('name', 'filterSpecialChars', 3, 'function'),
        array('created_at', 'datetime', 1, 'function'),
        array('updated_at', 'datetime', 3, 'function'),
    );
}
