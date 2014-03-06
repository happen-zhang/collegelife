<?php
namespace Home\Service;

/**
* UniversityService
*/
class UniversityService extends CommonService {
	/**
	 * 获得所有的分类
	 * @return array
	 */
    public function findAll() {
    	return $this->getD()->relation(true)->select();
    }

    protected function getM() {
        return M('University');
    }

    protected function getD() {
        return D('University');
    }

    protected function isRelation() {
        return true;
    }
}
