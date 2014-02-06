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
        unset($_SESSION['admin_name']);
        unset($_SESSION[C('SESSION_AUTH_KEY_ADMIN')]);
        unset($_SESSION['aid']);
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

    protected function getM() {
        return M('Admin');
    }

    protected function getD() {
        return D('Admin');
    }

    protected function isRelation() {
        return false;
    }
}
