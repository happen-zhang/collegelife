<?php
namespace Home\Service;

/**
* VisitorService
*/
class VisitorService extends CommonService {
    protected function getM() {
        return M('Visitor');
    }

    protected function getD() {
        return D('Visitor');
    }

    protected function isRelation() {
        return false;
    }
}
