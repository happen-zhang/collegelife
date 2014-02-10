<?php
namespace Home\Model;

use Think\Model\RelationModel;

/**
* order关联模型
*/
class OrderModel extends RelationModel {
    // 关联模型
    protected $_link = array(
        // 一个订单属于一个用户
        'user' => array(
            'mapping_type' => BELONGS_TO,
            'class_name' => 'user',
            'foreign_key' => 'user_id',
            'mapping_fields' => 'id, username, building_no',
        ),

        // 一个订单对应多个订单详情
        'order_goods_ships' => array(
            'mapping_type' => HAS_MANY,
            'class_name' => 'OrderGoodsShip',
            'foreign_key' => 'order_id',
        ),
    );
}
