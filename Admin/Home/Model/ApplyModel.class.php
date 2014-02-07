<?php
namespace Home\Model;

use Think\Model\RelationModel;

/**
* apply关联模型
*/
class ApplyModel extends RelationModel {
    // 关联
    protected $_link = array(
        'goods' => array(
            'mapping_type' => BELONGS_TO,
            'class_name' => 'goods',
            'foregin_key' => 'goods_id',
            'mapping_fields' => 'name,uuid'
        ),
    );

    // 自动完成
    // array(完成字段, 完成规则, 完成时间, 附加规则)
    protected $_auto = array(
        // 注册时间
        array('applied_at', 'datetime', 1, 'function'),
        // 修改时间
        array('updated_at', 'datetime', 3, 'function'),
        // 申请人
        array('applicant', 'getApplicant', 1, 'callback')
    );

    /**
     * 获得申请人
     * @return 
     */
    protected function getApplicant() {
        return $_SESSION['id'];
    }
}
