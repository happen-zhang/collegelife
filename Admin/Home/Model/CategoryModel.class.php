<?php
namespace Home\Model;

use Think\Model\RelationModel;

/**
 * Category关联模型
 */
class CategoryModel extends RelationModel {
    // 关联模型
    protected $_link = array(
        // 一个分类有多个商品
        'goods' => array(
            'mapping_type' => HAS_MANY,
            'class_name' => 'goods',
            'foreign_key' => 'category_id',
        ),
    );

    // 自动完成
    protected $_auto = array(
        array('uuid', 'uuid', 1, 'function'),
        array('name', 'filterSpecialChars', 3, 'function'),
        array('created_at', 'datetime', 1, 'function'),
        array('updated_at', 'datetime', 3, 'function'),
    );
}
