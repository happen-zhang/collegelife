<?php
namespace Home\Service;

use Think\Model;

/**
 * GoodsService
 */
class CategoryService extends Model {
    /**
     * 按uuid获取分类
     * @return array
     */
    public function getCategory($uuid) {
        $uuid = sql_injection($uuid);
        $category = D('Category')->where(array('uuid' => $uuid))->find();

        return $category;
    }
}
