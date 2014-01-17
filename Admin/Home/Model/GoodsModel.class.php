<?php
namespace Home\Model;

use Think\Model\RelationModel;

/**
 * Goods关联模型
 */
class GoodsModel extends RelationModel {
    // 关联模型
    protected $_link = array(
        // 一个商品对应一个类别
        'category' => array(
            'mapping_type' => BELONGS_TO,
            'class_name' => 'category',
            'foreign_key' => 'category_id',
            'mapping_fields' => 'id, uuid, name',
        ),

        // 一个商品对应多个评论
        'comments' => array(
            'mapping_type' => HAS_MANY,
            'class_name' => 'comment',
            'foregin_key' => 'goods_id'
        ),
    );
}
