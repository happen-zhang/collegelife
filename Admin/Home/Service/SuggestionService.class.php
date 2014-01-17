<?php
namespace Home\Service;

/**
* SuggestionService
*/
class SuggestionService extends CommonService {
    protected function getM() {
        return M('Suggestion');
    }

    protected function getD() {
        return D('Suggestion');
    }

    protected function isRelation() {
        return false;
    }
}
