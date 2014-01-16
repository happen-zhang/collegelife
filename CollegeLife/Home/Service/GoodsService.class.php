<?php
namespace Home\Service;

use Think\Model;

/**
 * GoodsService
 */
class GoodsService extends Model {
    /**
     * 按关键字查找商品
     * @param  string $keyword
     * @return array 
     */
    public function getGoodsByKeyword($keyword) {
        $keyword = sql_injection($keyword);
        $where['name'] = array('like', "%{$keyword}%");
        $goods = D('Goods')->relation(true)->where($where)->select();

        return $goods;
    }

    /**
     * 按分类获取商品
     * @param  int $cid
     * @return array 
     */
    public function getGoodsByCategoryId($cid) {
        $goods = D('Goods')
                  ->relation(true)
                  ->where(array('category_id' => $cid))
                  ->select();

        return $goods;
    }

    /**
     * 按id获取商品
     * @param  int $id
     * @return array
     */
    public function getGoodsById($id) {
        $goods = M('Goods')->where(array('id' => $id))->find();

        return $goods;
    }
}