<?php
include 'Global/Common/function.php';

/**
 * 获得管理员的等级
 * @param  int $rank
 * @return string
 */
function getAdminRank($rank) {
    $rankStr = '分管理员';
    switch ($rank) {
        case 1:
            $rankStr = '分管理员';
            break;

        case 2:
            $rankStr = '总管理员';
            break;

        case 3:
            $rankStr = '总部';
            break;
    }

    return $rankStr;    
}