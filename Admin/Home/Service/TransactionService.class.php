<?php
namespace Home\Service;

/**
* TransactionService
*/
class TransactionService extends CommonService {
    /**
     * 按分配人查找
     * @param  int $assign_to
     * @return array
     */
    public function findByAssigner($assign_to) {
        return $this->getM()
                    ->where(array('assign_to' => $assign_to))
                    ->select();
    }

	/**
	 * 获得所有的转账
	 * @return array
	 */
    public function findAll() {
    	return $this->getD()->relation(true)->select();
    }

    protected function getM() {
        return M('Transaction');
    }

    protected function getD() {
        return D('Transaction');
    }

    protected function isRelation() {
        return true;
    }
}
