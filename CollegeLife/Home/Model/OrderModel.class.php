<?php
namespace Home\Model;

use Think\Model\RelationModel;

class OrderModel extends RelationModel {
	// 关联模型
	protected $_link = array(
		// 一个订单对应多个订单详情
        'order_goods_ships' => array(
            'mapping_type' => HAS_MANY,
            'class_name' => 'OrderGoodsShip',
            'foreign_key' => 'order_id',
        ),
	);
}