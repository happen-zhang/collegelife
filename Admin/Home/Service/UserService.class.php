<?php
namespace Home\Service;

/**
* UserService
*/
class UserService extends CommonService {
    /**
     * 获取用户信息和订单信息
     * @param  string $id
     * @return array
     */
    public function getUserDetail($id) {
        $User = D('User');
        $user = $User->relation(true)
                     ->where(array('id' => $id))
                     ->find();
        
        return $user;
    }

    /**
     * 获取指定栋号的用户
     * @param  array  $buildingNo
     * @param  array  $fields
     * @return array
     */
    public function getUserByBuildingNo(array $buildingNo, array $fields) {
        $where['building_no'] = array('in', $buildingNo);
        $users = M('User')->where($where)->field($fields)->select();

        return $users;
    }

    /**
     * 更新密码
     * @param  string $uuid
     * @param  string $newPassword
     * @return int
     */
    public function updatePassword($uuid, $newPassword) {
        $where['uuid'] = $uuid;
        $newPassword = md5($newPassword);
        $update['password'] = $newPassword;

        return $this->getM()->where($where)->save($update);
        // $this->getM()->getDbError();
        // exit();
    }

    protected function getM() {
        return M('User');
    }

    protected function getD() {
        return D('User');
    }

    protected function isRelation() {
        return true;
    }    
}
