<?php
namespace Home\Model;

use Think\Model\RelationModel;

/**
 * Order关联模型
 */
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

    // 自动完成
    protected $_auto = array(
        // 生成uuid
        array('uuid', 'uuid', 1, 'function'),
        // 注册时间
        array('created_at', 'datetime', 1, 'function'),
        // 修改时间
        array('updated_at', 'datetime', 3, 'function'),        
    );
}