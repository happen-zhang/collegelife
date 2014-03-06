<?php
namespace Home\Model;

use Think\Model\RelationModel;

/**
* user关联模型
*/
class UserModel extends RelationModel {
    // 批量验证
    protected $patchValidate = true;

    // 关联模型
    protected $_link = array(
        // 一个用户对应多个订单
        'orders' => array(
            'mapping_type' => HAS_MANY,
            'class_name' => 'order',
            'foreign_key' => 'user_id',
        ),

        // 一个用户对应一个学院
        'university' => array(
            'mapping_type' => BELONGS_TO,
            'class_name' => 'university',
            'foreign_key' => 'university_id',
        )
    );
}
