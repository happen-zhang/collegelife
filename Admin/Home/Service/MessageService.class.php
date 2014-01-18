<?php
namespace Home\Service;

/**
* MessageService
*/
class MessageService extends CommonService {
    protected function getM() {
        return M('Message');
    }

    protected function getD() {
        return D('Message');
    }

    protected function isRelation() {
        return true;
    }
}
