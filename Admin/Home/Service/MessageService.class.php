<?php
namespace Home\Service;

use Think\Model;

/**
* MessageService
*/
class MessageService extends Model {
    /**
     * 获取所有的总数
     * @return
     */
    public function getCount() {
        $count = M('Message')->count();

        return $count;
    }

    /**
     * 分页获取
     * @param  int $firstRow
     * @param  int $listRows
     * @return array
     */
    public function getPagination($firstRow, $listRows) {
        $Message = D('Message');
        $messages = $Message->relation(true)
                        ->order('id DESC')
                        ->limit($firstRow . ',' . $listRows)
                        ->select();

        return $messages;
    }
}
