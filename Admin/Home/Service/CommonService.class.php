<?php
namespace Home\Service;

use Think\Model;

/**
* CommonService
*/
abstract class CommonService extends Model {
    /**
     * 获取所有的总数
     * @return
     */
    public function getCount() {
        $count = $this->getM()->count();

        return $count;
    }

    /**
     * 分页获取
     * @param  int $firstRow
     * @param  int $listRows
     * @return array
     */
    public function getPagination($firstRow, $listRows) {
        $D = $this->getD();

        if ($this->isRelation()) {
            $data = $D->relation(true)
                      ->order('id DESC')
                      ->limit($firstRow . ',' . $listRows)
                      ->select();            
        } else {
            $data = $D->order('id DESC')
                      ->limit($firstRow . ',' . $listRows)
                      ->select();
        }

        return $data;
    }

    /**
     * 不激活状态
     * @param  string $uuid
     * @return boolean
     */
    public function deactive($uuid) {
        return $this->changeActiveStatus($uuid, 0);
    }

    /**
     * 激活状态
     * @param  string $uuid
     * @return boolean
     */
    public function active($uuid) {
        return $this->changeActiveStatus($uuid, 1);
    }

     /**
     * 改变激活状态
     * @param  string $uuid   
     * @param  boolean $active
     * @return boolean
     */
    protected function changeActiveStatus($uuid, $active) {
        $M = $this->getM();

        $where['uuid'] = $uuid;
        $data['is_active'] = $active;
        if (false === $M->where($where)->save($data)) {
            return false;
        }

        return true;
    }

    /**
     * 得到一个分页对象
     * @param  string $varName
     * @return \Org\Util\Page
     */
    protected function getPage($varName, $totalCount) {
        $page = new \Org\Util\Page($totalCount,
                                   C('PAGINATION_NUM'),
                                   $varName);

        return $page;
    }

    /**
     * 获得M
     * @return model
     */
    abstract protected function getM();

    /**
     * 获得D
     * @return model
     */
    abstract protected function getD();

    /**
     * 是否开启关联
     * @return boolean
     */
    abstract protected function isRelation();
}
