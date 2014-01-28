<?php
namespace Home\Service;

/**
* OrderService
*/
class OrderService extends CommonService {
    /**
     * 获取所有的订单
     * @return
     */
    public function getOrders() {
        $orders = D('Order')->relation(true)
                            ->order('id DESC')
                            ->select();

        return $orders;  
    }

    /**
     * 订单发货
     * @param  string $uuid
     * @return boolean
     */
    public function consignOrder($uuid) {
        $Order = M('Order');
        $order['consignment_at'] = datetime();
        $order['order_status'] = '已发货';
        $order['admin_id'] = $_SESSION['id'];
        $where['uuid'] = $uuid;
        if (false === $Order->where($where)->save($order)) {
            return false;
        }

        return true;
    }

    /**
     * 订单付款
     * @param  string $uuid
     * @return boolean
     */
    public function payOrder($uuid) {
        $Order = D('Order');
        $where['uuid'] = $uuid;
        $order['payment_status'] = '已收款';
        $order['admin_id'] = $_SESSION['id'];
        $order['payment_at'] = datetime();

        if (false === $Order->where($where)->save($order)) {
            return false;
        }

        // 增加商品销量 更新用户已购信息
        $order = $Order->relation(true)->where($where)->find();
        $bought['user_id'] = $order['user_id'];
        foreach ($order['order_goods_ships'] as $subOrder) {
            $goodsId = $subOrder['goods_id'];
            $bought['goods_id'] = $goodsId;
            M('Goods')->where(array('id' => $goodsId))->setInc('sold_count');
            M('Bought')->add($bought);
        }

        return true;
    }

    /**
     * 获取订单的详情
     * @param  string $uuid
     * @return array  订单商品，商品数量，订单总价
     */
    public function getOrderDetail($orderUuid) {
        $uuid = sql_injection($orderUuid);
        $order = D('Order')->relation(true)
                           ->where(array('uuid' => $orderUuid))
                           ->find();

        // 无效的订单
        if (!$order) {
            return null;
        }

        // 获取所有订单中的商品
        $orderGoodsShips = $order['order_goods_ships'];
        foreach ($orderGoodsShips as $key => $orderGoodsShip) {
            $orderGoodsShip = D('OrderGoodsShip')
                               ->relation(true)
                               ->where(array('id' => $orderGoodsShip['id']))
                               ->find();
            $orderGoodsShip['goods']['count'] = $orderGoodsShip['goods_count'];
            $goods[] = $orderGoodsShip['goods'];
        }

        // 获取商品分类
        foreach ($goods as $key => $item) {
            $item = D('Goods')->relation(true)
                              ->where(array('id' => $item['id']))
                              ->find();
            $goods[$key]['category'] = $item['category']['name'];
        }

        unset($order['order_goods_ships']);
        $order['goods'] = $goods;

        return $order;
    }
    
    /**
     * 分管理员按楼栋数管理订单
     * @return array
     */
    public function getCount() {
        if ($_SESSION['rank'] == 3) {
            return parent::getCount();
        }

        // 获取管理员所管理的用户的id
        $userIds = $this->getUseridByAdmin($_SESSION['id']);

        // 用户的订单数
        $where['user_id'] = array('in', $userIds);
        $orderCnt = M('Order')->where($where)->count();

        return $orderCnt;
    }

    /**
     * 
     * @param  int $firstRow
     * @param  int $listRows
     * @return array
     */
    public function getPagination($firstRow, $listRows) {
        if ($_SESSION['rank'] == 3) {
            return parent::getPagination($firstRow, $listRows);
        }

        $userIds = $this->getUseridByAdmin($_SESSION['id']);
        $where['user_id'] = array('in', $userIds);

        $D = $this->getD();
        $orders = $D->relation(true)
                    ->where($where)
                    ->order('id DESC')
                    ->limit($firstRow . ',' . $listRows)
                    ->select();

        return $orders;
    }

    protected function getM() {
        return M('Order');
    }

    protected function getD() {
        return D('Order');
    }

    protected function isRelation() {
        return true;
    }

    /**
     * 返回用户id数组
     * @param  int $id
     * @return array
     */
    private function getUseridByAdmin($id) {
        // 获取管理员所管理的用户
        $adminService = D('Admin', 'Service');
        $users = $adminService->getUserBelongsAdmin($id, array('id'));
        $userIds = array();
        foreach ($users as $user) {
            $userIds[] = $user['id'];
        }
        $userIds = implode(',', $userIds);

        return $userIds;
    }
}
