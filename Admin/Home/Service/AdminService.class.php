<?php
namespace Home\Service;

/**
* AdminService
*/
class AdminService extends CommonService {
    /**
    * 管理员登录
    * @param  array $data 管理员登陆数据
    * @return boolean   
    */
    public function login($data) {
        // 防注入
        $admin_name = sql_injection(htmlspecialchars($data['admin_name']));
        $password = sql_injection(htmlspecialchars($data['password']));
        $admin['admin_name'] = $admin_name;
        $admin['password'] = md5($password);
        // 状态为激活
        $admin['is_active'] = 1;

        $Admin = M('Admin');
        $result = $Admin->where($admin)->find();
        if (!empty($result)) {
            // 更新最近登陆时间
            $result['latest_login_at'] = datetime();
            $Admin->save($result);

            // session
            $_SESSION['admin_name'] = $result['admin_name'];
            $_SESSION[C('SESSION_AUTH_KEY_ADMIN')]
                     = md5($result['admin_name'] . C('COOKIE_NAME'));
            $_SESSION['aid'] = $result['uuid'];
            $_SESSION['id'] = $result['id'];
            $_SESSION['rank'] = $result['rank'];
            $_SESSION['university_id'] = $result['university_id'];

            return true;
        } else {
            // 密码错误
            return false;
        }
    }

    /**
    * 管理员登出
    * @return
    */
    public function logout() {
        // 清除session
        if (isset($_SESSION[C('SESSION_AUTH_KEY_ADMIN')])) {
            unset($_SESSION);
            session_destroy();            
        }
    }

    /**
     * 按id查找
     * @return admin
     */
    public function findById($id) {
        return $this->getM()
                    ->where(array('id' => $id))
                    ->find();
    }

    /**
     * 获得指定id管理员所管理的楼栋号
     * @param  int $id
     * @return array
     */
    public function getAdminBuildings($id) {
        // 得到管理楼栋号
        $where['id'] = $id;
        $fields = array('buildings');
        $admin = M('Admin')->where($where)->field($fields)->find();
        $buildings = explode(',', $admin['buildings']);

        return $buildings;        
    }

    /**
     * 获得管理员所管理的用户
     * @param  $adminId
     * @return array
     */
    public function getUserBelongsAdmin($adminId, array $fields) {
        // 得到管理楼栋号
        $buildings = $this->getAdminBuildings($adminId);

        // 获取楼栋号的用户
        $userService = D('user', 'Service');
        $users = $userService->getUserByBuildingNo($buildings, $fields);

        return $users;
    }

    /**
     * 获得管理员信息和处理订单详情
     * @param  string $uuid
     * @return array
     */
    public function getAdminDetail($uuid) {
        $admin = D('Admin')->relation(true)
                           ->where(array('uuid' => $uuid))
                           ->find();
        $admin['rank'] = $this->getRank($admin['rank']);
        $admin['buildings'] = implode('栋 ', explode(',', $admin['buildings']));
        $admin['buildings'] .= '栋';
        $admin['transactions'] = $this->getAdminTransaction($admin['id']);

        return $admin;
    }

    /**
     * 获得管理员的等级
     * @param  int $rank
     * @return string
     */
    public function getRank($rank) {
        return getAdminRank($rank);
    }

    /**
     * 不激活管理员
     * @param  string $uuid
     * @return boolean
     */
    public function deactiveAdmin($uuid) {
        return $this->changeActiveStatus($uuid, 0);
    }

    public function getCount() {
        if ($_SESSION['rank'] == 2) {
            // 得到总管理管理的栋号d
            $buildings = $this->getAdminBuildings($_SESSION['id']);

            return $this->getAdminConut($buildings[0], 1);
        }
        
        return $this->getM()
                    ->where(array('id' => array('neq', $_SESSION['id'])))
                    ->count();
    }

    public function getPagination($firstRow, $listRows) {
        if ($_SESSION['rank'] == 2) {
            // $buildings = $this->getAdminBuildings($_SESSION['id']);
            // return $this->getAdmins($firstRow, $listRows, $buildings[0], 1);
            
            return $this->getAdmins($firstRow,
                                    $listRows,
                                    $_SESSION['university_id'], 1);
        }

        return $this->getD()
                    ->relation(true)
                    ->order('latest_login_at DESC')
                    ->where(array('id' => array('neq', $_SESSION['id'])))
                    ->limit($firstRow . ',' . $listRows)
                    ->select();
    }

    /**
     * 得到管理的总数
     * @return int
     */
    public function getAdminConut($buildings, $rank) {
        $where = array();
        if (isset($buildings)) {
            $where['buildings'] = array('like', '%' . $buildings . '%');
        }

        if (isset($rank)) {
            $where['rank'] = 1;
        }

        $count = $this->getM()->where($where)->count();

        return $count;
    }

    /**
     * 得到管理员
     * @param  string $buildings
     * @param  int $rank
     * @return array
     */
    // public function getAdmins($firstRow, $listRows, $buildings, $rank) {
    //     $where = array();
    //     if (isset($buildings)) {
    //         $where['buildings'] = $buildings;
    //     }

    //     if (isset($rank)) {
    //         $where['rank'] = 1;
    //     }

    //     return $this->getD()
    //                 ->order('latest_login_at DESC')
    //                 ->where($where)
    //                 ->limit($firstRow . ',' . $listRows)
    //                 ->select();
    // }

    /**
     * 得到管理员
     * @param  int $uity_id
     * @param  int $rank
     * @return array
     */
    public function getAdmins($firstRow, $listRows, $uity_id, $rank) {
        $where = array();
        if (isset($uity_id)) {
            $where['university_id'] = $uity_id;
        }

        if (isset($rank)) {
            $where['rank'] = $rank;
        } else {
            $where['rank'] = 1;
        }

        $queryObject = $this->getD()
                      ->order('latest_login_at DESC')
                      ->where($where);

        if (!$firstRow || !$listRows) {
            return $queryObject->select();
        }

        return $queryObject->limit($firstRow . ',' . $listRows)
                           ->select();        
    }

    /**
     * 获得订单操作状态
     * @return array
     */
    public function getAdminDoOrder($adminId) {
        $AdminDoOrder = M('AdminDoOrder');
        $doOrders = $AdminDoOrder->where(array('admin_id' => $adminId))
                                 ->select();

        $admin = M('Admin')->where(array('id' => $adminId))
                           ->field(array('admin_name'))
                           ->find();

        foreach ($doOrders as $key => $doOrder) {
            $doOrders[$key]['admin_name'] = $admin['admin_name'];

            $order = M('Order')->where(array('id' => $doOrder['order_id']))
                               ->field(array('uuid'))
                               ->find();

            $doOrders[$key]['uuid'] = $order['uuid'];
        }

        return $doOrders;
    }

    /**
     * 得到管理员转账
     * @return array
     */
    public function getAdminTransaction($adminId) {
        $where['admin_id'] = $adminId;
        $transactions = M('Transaction')->where($where)->select();

        foreach ($transactions as $key => $transaction) {
            $order = M('Order')->where(array('id' => $transaction['order_id']))
                               ->field(array('uuid'))
                               ->find();

            $transactions[$key]['order_uuid'] = $order['uuid'];
        }

        return $transactions;
    }

    /**
     * 获得申请货款
     * @param  int $adminId
     * @return array
     */
    public function getApplies($adminId) {
        $where['applicant'] = $adminId;
        $Apply = D('Apply');
        $applies = $Apply->relation(true)
                         ->where($where)
                         ->order('id DESC')
                         ->select();

        return $applies;
    }

    /**
     * 获得同一栋的所有管理员
     * @return array
     */
    public function getAdminsByBuilding($building, $fields) {
        $Admin = $this->getM();

        $where['buildings'] = $building;
        return $Admin->where($where)->field($fields)->select();
    }

    /**
     * 返回指定栋号的一类管理员
     * @param  string $building
     * @param  int $rank
     * @return array
     */
    public function getOneAdminsByBuilding($building, $rank) {
        $where['buildings'] = $building;
        $where['rank'] = $rank;

        return $this->getM()
                    ->where($where)
                    ->select();
    }

    /**
     * 得到指定栋的总管理员
     * @param  string $building
     * @return
     */
    public function getSeniorByBuilding($building) {
        $admins = $this->getOneAdminsByBuilding($building, 2);
        return $admins[0];
    }

    /**
     * 更新密码
     * @param  string $originPassword
     * @param  string $newPassword
     * @return int
     */
    public function updatePassword($uuid, $originPassword, $newPassword) {
        $where['password'] = md5($originPassword);
        $where['uuid'] = $uuid;

        // 原密码错误
        $admin = $this->getM()->where($where)->find();
        if (empty($admin)) {
            return 0;
        }

        // 更新密码失败
        unset($where['password']);
        $newPassword = md5($newPassword);
        $update['password'] = $newPassword;
        if (false === $this->getM()->where($where)->save($update)) {
            return -1;
        }

        // 更新密码成功
        return 1;
    }

    /**
     * 按rank获得管理员
     * @param  int $rank
     * @return array
     */
    public function findByRank($rank) {
        return $this->getM()
                    ->where(array('rank'=> $rank))
                    ->select();
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

    protected function getM() {
        return M('Admin');
    }

    protected function getD() {
        return D('Admin');
    }

    protected function isRelation() {
        return true;
    }
}
