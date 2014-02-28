<?php
namespace Home\Model;

use Think\Model\RelationModel;

/**
 * TransactionModel
 */
class TransactionModel extends RelationModel {

    // 关联模型
    protected $_link = array(
        // 一个分类有多个商品
        'order' => array(
            'mapping_type' => BELONGS_TO,
            'class_name' => 'order',
            'foreign_key' => 'order_id',
        ),
    );
}
