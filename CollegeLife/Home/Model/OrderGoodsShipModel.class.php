<?php
namespace Home\Model;

use Think\Model\RelationModel;

class OrderGoodsShipModel extends RelationModel {
    // 关联模型
    protected $_link = array(
        // 一个订单详情对应一个商品
        'goods' => array(
            'mapping_type' => BELONGS_TO,
            'class_name' => 'goods',
            'foreign_key' => 'goods_id',
            'mapping_fields' => 'id, uuid, name, price',
        ),
    );
}
