<?php
namespace Home\Service;

/**
* GoodsService
*/
class GoodsService extends CommonService {
    /**
     * 获取所有的总数
     * @return
     */
    public function getCount($categoryId) {
        $where['id'] = $categoryId;
        $count = $this->getM()->where($where)->count();

        return $count;
    }

    /**
     * 分页获取
     * @param  int $firstRow
     * @param  int $listRows
     * @return array
     */
    public function getPagination($firstRow, $listRows, $categoryId) {
        $D = $this->getD();

        $where['category_id'] = $categoryId;
        $data = $D->where($where)
                  ->order('id DESC')
                  ->limit($firstRow . ',' . $listRows)
                  ->select();

        return $data;
    }

    /**
     * 按uuid获得商品
     * @param  string $uuid
     * @return array
     */
    public function getGoods($uuid) {
        $goods = D('Goods')->relation(true)
                           ->where(array('uuid' => $uuid))
                           ->find();

        return $goods;
    }

    protected function getM() {
        return M('Goods');
    }

    protected function getD() {
        return D('Goods');
    }

    protected function isRelation() {
        return true;
    }
}
