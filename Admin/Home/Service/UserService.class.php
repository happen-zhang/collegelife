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
                     ->where(array('id' => $_GET['user_id']))
                     ->find();
        
        return $user;
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
