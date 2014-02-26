<?php
namespace Home\Controller;

/**
* OrdersController
*/
class OrdersController extends CommonController {
    /**
     * _initialize
     * @return
     */
    public function _initialize() {
        parent::_initialize();

        // 购买产品页不需过滤
        if (ACTION_NAME != 'build') {
            $this->accessFilter();
        }

        $this->assign('ctrl_name', 'Order');
    }

    /**
    * 用户订单列表
    * @return
    */
    public function index() {
        if (!isset($_SESSION['uid'])) {
            $this->error('无效的操作！');
        }

        $orders = D('Order', 'Service')->getUserOrders($_SESSION['uid']);
        $this->assignToken();
        $this->assign('orders', $orders);
        $this->display();
    }

    /**
     * 显示单个订单信息
     * @return
     */
    public function show() {
        if (!isset($_GET['order_id'])) {
            $this->error("您指定的订单号不存在！");
        }

        $order = D('Order', 'Service')->getOrderDetail($_GET['order_id']);
        if (is_null($order)) {
            $this->error("您指定的订单号不存在！");
        }

        $this->assign('order', $order);
        $this->assign('goods', $order['goods']);
        $this->display();
    }

    /**
    * 商品下订单
    * @return
    */
    public function build() {
        if (!isset($_GET['goods_id'])) {
            $this->error('您查看的商品不存在！');
        }

        $uuid = sql_injection($_GET['goods_id']);
        $goods = D('Goods')->relation(true)
                           ->where(array('uuid' => $uuid))
                           ->find();

        if (is_null($goods) || false === $goods) {
            $this->error('您查看的商品不存在！');
        }

        $this->assignToken();
        $this->assign('goods', $goods);
        $this->display();
    }

    /**
     * RESTful create
     * @return
     */
    public function create() {
        // 无效表单请求
        $this->unvalidFormReq();

        // 错误处理
        if (!isset($_SESSION['uid'])
            || !isset($_POST['goods_id'])
            || !is_numeric($_POST['goods_id'])
            || !isset($_POST['goods_count'])
            || !is_numeric($_POST['goods_count'])
            || $_POST['goods_count'] <= 0) {
            $this->error('无效的操作！');
        }

        $goods_count = $_POST['goods_count'];
        $goods_id = $_POST['goods_id'];

        // 获取当前用户的id作为订单外键
        if (!($goods = D('Goods', 'Service')->getGoodsById($goods_id))) {
            $this->error('您购买的商品不存在！');
        }

        // 获取当前用户的id作为订单外键
        if(!($user = D('User', 'Service')->getUserByUuid($_SESSION['uid']))) {
            $this->error('无效的操作！');
        }

        $Order = D('Order');
        $order = array('user_id' => $user['id'], 
                       'payment' => $goods['preferential'] * $goods_count);
        if ($order = $Order->create($order)) {
            if (false === $Order->add($order)) {
                $this->error($Order->getDbError());
            }
        } else {
            $this->error($Order->getError());
        }

        $OrderGoodsShip = D('OrderGoodsShip');
        $subOrder = array('order_id' => $Order->getLastInsID(), 
                          'goods_id' => $goods_id,
                          'goods_count' => $goods_count,
                          'order_payment' => $order['payment']);
        if ($OrderGoodsShip->add($subOrder)) {
            // 无效token
            $this->destroyToken();
            // 操作成功，跳转到订单页
            $url = U('Orders/index', array('uid' => $_SESSION['uid']));
            $this->success('感谢您的购买，我们将尽快处理您的订单！', $url);
        } else {
            $this->error($OrderGoodsShip->getDbError());
        }
    }

    /**
     * RESTful destroy
     * @return
     */
    public function destory() {
        if (!isset($_GET['order_id']) || !isset($_GET['hash'])
            || !isset($_SESSION['uid'])
            || $_SESSION[C('TOKEN_NAME')] != $_GET['hash']) {
            $this->error('无效的操作！');
        }

        $uuid = sql_injection($_GET['order_id']);
        $flag = M('Order')->where(array('uuid' => $uuid))->delete();
        if (false === $flag) {
            // 操作失败
            $this->redirect('Orders/index', array('status' => 2));
        }

        // 操作成功
        $this->redirect('Orders/index', array('status' => 1));
    }

    /**
     * 取消订单
     * @return
     */
    public function cancel() {
        if (!isset($_GET['order_id']) || !isset($_GET['hash'])
            || !isset($_SESSION['uid'])
            || $_SESSION[C('TOKEN_NAME')] != $_GET['hash']) {
            $this->error('无效的操作！');
        }

        $uuid = sql_injection($_GET['order_id']);
        $flag = M('Order')->where(array('uuid' => $uuid))
                          ->save(array('is_cancel' => 1));

        if (false === $flag) {
            // 操作失败
            $this->redirect('Orders/index', array('status' => 2));
        }

        // 操作成功
        $this->redirect('Orders/index', array('status' => 1));
    }
}
