<?php
namespace Home\Service;

/**
* CategoryService
*/
class CategoryService extends CommonService {
	/**
	 * 获得所有的分类
	 * @return array
	 */
    public function findAll() {
    	return $this->getD()->relation(true)->select();
    }

    protected function getM() {
        return M('Category');
    }

    protected function getD() {
        return D('Category');
    }

    protected function isRelation() {
        return true;
    }
}
