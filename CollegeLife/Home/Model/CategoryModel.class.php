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
            'mapping_fields' => 'uuid, name, description,
                                 price, preferential, sold_count',
        ),
    );
}