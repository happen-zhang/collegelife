<?php
namespace Home\Model;

use Think\Model\RelationModel;

/**
 * OrderGoods关联模型
 */
class MessageModel extends RelationModel {
    // 关联模型
    protected $_link = array(
        // 一条信息属于一个管理员
        'admin' => array(
            'mapping_type' => BELONGS_TO,
            'class_name' => 'admin',
            'foreign_key' => 'admin_id',
            'mapping_fields' => 'admin_name',
        ),
    );

    // 自动完成
    protected $_auto = array(
        // 转义特殊字符
        array('content', 'filterSpecialChars', 3, 'function'),
        // 注册时间
        array('created_at', 'datetime', 1, 'function'),
        // 修改时间
        array('updated_at', 'datetime', 3, 'function'),
        // 发布者
        array('admin_id', 'publishBy', 1, 'callback'),
    );

    /**
     * 通知发布者
     * @return 
     */
    protected function publishBy() {
        $uuid = $_SESSION['aid'];
        $admin = M('Admin')->field('id')
                           ->where(array('uuid' => $uuid))
                           ->find();
        return $admin['id'];
    }
}
