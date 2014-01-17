<?php
namespace Home\Service;

use Think\Model;

/**
* OrderService
*/
class OrderService extends Model {
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
     * 获取所有订单的总数
     * @return
     */
    public function getCount() {
        $count = M('Order')->count();

        return $count;
    }

    /**
     * 分页获取订单
     * @param  int $firstRow
     * @param  int $listRows
     * @return array
     */
    public function getPagination($firstRow, $listRows) {
        $Order = D('Order');
        $orders = $Order->relation(true)
                        ->order('id DESC')
                        ->limit($firstRow . ',' . $listRows)
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
        $Order = M('Order');
        $where['uuid'] = $uuid;
        $order['payment_status'] = '已收款';

        if (false === $Order->where($where)->save($order)) {
            return false;
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
}
