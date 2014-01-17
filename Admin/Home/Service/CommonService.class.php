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
