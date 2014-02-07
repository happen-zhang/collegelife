<?php
namespace Home\Service;

/**
* ApplyService
*/
class ApplyService extends CommonService {
    protected function getM() {
        return M('Apply');
    }

    protected function getD() {
        return D('Apply');
    }

    protected function isRelation() {
        return false;
    }

    public function getCount() {
        $where['applicant'] = $_SESSION['id'];
        $count = $this->getM()->where($where)->count();

        return $count;
    }

    public function getPagination($firstRow, $listRows) {
        $D = $this->getD();

        $where['applicant'] = $_SESSION['id'];
        $data = $D->relation(true)
                  ->order('id DESC')
                  ->where($where)
                  ->limit($firstRow . ',' . $listRows)
                  ->select();

        return $data;
    }    

    /**
     * 得到申请
     * @param  string $adminIds
     * @return array
     */
    public function getAppliesByAdminIds($adminIds) {
        $Apply = D('Apply');
        $where['applicant'] = array('in', $adminIds);
        $applies = $Apply->relation(true)
                         ->where($where)
                         ->select();

        foreach ($applies as $key => $apply) {
            $admin = M('Admin')->where(array('id' => $apply['applicant']))
                               ->field(array('admin_name', 'uuid'))
                               ->order('id DESC')
                               ->find();
            $applies[$key]['admin_name'] = $admin['admin_name'];
            $applies[$key]['admin_uuid'] = $admin['uuid'];
        }

        return $applies;
    }
}
