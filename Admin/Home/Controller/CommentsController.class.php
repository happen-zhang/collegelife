<?php
namespace Home\Controller;

/**
 * CommentController
 */
class CommentsController extends CommonController {
    /**
     * 删除评论
     * @return
     */
    public function destroy() {
        if (!isset($_GET['comment_id'])) {
            $this->error('无效的操作！');
        }

        $Comment = M('Comment');
        $where['id'] = $_GET['comment_id'];
        if (false === $Comment->where($where)->delete()) {
            $this->error('系统出错了！');
        }

        $this->redirect('Goods/show', array('goods_id' => $_GET['goods_id']));
    }
}
