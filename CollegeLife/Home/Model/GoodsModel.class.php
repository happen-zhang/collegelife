<?php
namespace Home\Model;

use Think\Model\RelationModel;

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
	);
}