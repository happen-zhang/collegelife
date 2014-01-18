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

    // 自动验证
    // array(验证字段, 验证规则, 错误信息, 验证条件, 附加规则, 验证时间)
    protected $_validate = array(
        // 产品名为空验证
        array('name', 'require', '产品名不能为空！', 1, 'regex', 1),
        // 产品名长度验证
        array('name', '1, 32', '产品名长度只能在1~32个字符之间！',
              1, 'length', 1),
        // 产品分类不能为空
        array('category_id', 'require', '产品分类不能为空！', 1, 'regex', 1),
        // 产品价格为空验证
        array('price', 'require', '产品价格不能为空！', 1, 'regex', 1),
        array('price', 'is_numeric', '产品价格必须是数字！', 2, 'function', 3),
        // 产品价格为空验证
        array('preferential', 'require', '产品特惠价格不能为空！', 1, 'regex', 1),
        array('preferential', 'is_numeric', '产品特惠价格必须是数字！', 2, 
              'function', 3),
        // 产品库存为空验证
        array('stock', 'require', '产品库存不能为空！', 1, 'regex', 1),
        array('stock', 'is_numeric', '产品库存必须是数字！', 2, 'function', 3),
    );

    // 自动完成
    // array(完成字段, 完成规则, 完成时间, 附加规则)
    protected $_auto = array(
        // 生成uuid
        array('uuid', 'uuid', 1, 'function'),
        // 注册时间
        array('created_at', 'datetime', 1, 'function'),
        // 修改时间
        array('updated_at', 'datetime', 3, 'function'),
        // 转义特殊字符
        array('name', 'filterSpecialChars', 3, 'function'),
        array('description', 'filterSpecialChars', 3, 'function'),
        array('brand', 'filterSpecialChars', 3, 'function'),
        array('feature', 'filterSpecialChars', 3, 'function'),
        array('net_wt', 'filterSpecialChars', 3, 'function'),
        array('place_origin', 'filterSpecialChars', 3, 'function'),
        array('qgp', 'filterSpecialChars', 3, 'function'),
        array('suitable', 'filterSpecialChars', 3, 'function'),
        array('remind', 'filterSpecialChars', 3, 'function'),
    );
}
