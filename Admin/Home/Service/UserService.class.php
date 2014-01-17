<?php
namespace Home\Service;

use Think\Model;

/**
* UserService
*/
class UserService extends Model {
    /**
     * 获取所有的总数
     * @return
     */
    public function getCount() {
        $count = M('User')->count();

        return $count;
    }

    /**
     * 分页获取
     * @param  int $firstRow
     * @param  int $listRows
     * @return array
     */
    public function getPagination($firstRow, $listRows) {
        $User = D('User');
        $users = $User->relation(true)
                        ->order('id DESC')
                        ->limit($firstRow . ',' . $listRows)
                        ->select();

        return $users;
    }

    /**
     * 获取用户信息和订单信息
     * @param  string $id
     * @return array
     */
    public function getUserDetail($id) {
        $User = D('User');
        $user = $User->relation(true)
                     ->where(array('id' => $_GET['user_id']))
                     ->find();
        
        return $user;
    }

    /**
     * 不激活用户
     * @param  string $uuid
     * @return boolean
     */
    public function deactiveUser($uuid) {
        return $this->changeActiveStatus($uuid, 0);
    }

    /**
     * 激活用户
     * @param  string $uuid
     * @return boolean
     */
    public function activeUser($uuid) {
        return $this->changeActiveStatus($uuid, 1);
    }

    /**
     * 改变用户激活状态
     * @param  string $uuid   
     * @param  boolean $active
     * @return boolean
     */
    private function changeActiveStatus($uuid, $active) {
        $User = M('User');

        $where['uuid'] = $uuid;
        $user['is_active'] = $active;
        if (false === $User->where($where)->save($user)) {
            return false;
        }

        return true;        
    }
}
