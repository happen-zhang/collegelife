<?php
namespace Home\Controller;

/**
 * GoodsController
 */
class GoodsController extends CommonController {
    /**
     * 商品管理
     * @return
     */
    public function index(){
        $Category = M('Category');
        $categories = $Category->field('id, name')->select();

        if (isset($_GET['category_id'])) {
            $where = array('id' => $_GET['category_id']);
            $currentCategory = $Category->where($where)->find();
        }

        if (empty($currentCategory)) {
            $currentCategory = $categories[0]['id'];
        }

        $result = $this->pagination('Goods', $currentCategory['id']);

        $this->assign('page', $result['show']);
        $this->assign('goods', $result['data']);
        $this->assign('categories', $categories);
        $this->assign('curr_category', $currentCategory);
        $this->display();
    }

    /**
     * 商品详情
     * @return
     */
    public function show() {
        if (!isset($_GET['goods_id'])) {
            $this->error('您查看的商品不存在！');
        }

        $goodsService = D('Goods', 'Service');
        $goods = $goodsService->getGoods($_GET['goods_id']);
        if (is_null($goods)) {
            $this->error('您查看的商品不存在！');
        }

        $this->assign('goods', $goods);
        $this->display();
    }

    /**
     * 添加商品
     * @return
     */
    public function create() {
        if (!isset($_POST['goods'])) {
            $this->error('无效的操作！');
        }

        $Goods = D('Goods');
        if (!($goods = $Goods->create($_POST['goods']))) {
            // 数据验证失败
            $this->error($Goods->getError());
        }

        // 上传图片
        $uploadList = $this->uploadImg();
        // 保存logo图片的路径
        if (!empty($uploadList)) {
            $goods['logo'] = $uploadList[0]['savename'];
        }

        // 保存到数据库
        if (false === $Goods->add($goods)) {
            // 插入数据失败
            $this->error('系统出错了！');
        }

        // 获取展示图片的路径
        array_shift($uploadList);
        if (!count($imgs = $this->getImagesPath($uploadList))) {
            // 不需要展示图片
            $this->redirect('Goods/index');
        }

        // 添加商品图片
        $this->addGoodsImages($Goods->getLastInsID(), $imgs);

        $this->redirect('Goods/index');
    }

    /**
     * 上传图片
     * @return
     */
    private function uploadImg() {
        $upload = new \Org\Util\UploadFile();

        // 文件大小
        $upload->maxSize = 3292200;
         //设置上传文件类型
        $upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
         //设置附件上传目录
        $upload->savePath = C('UPLOAD_PATH');
        // 唯一
        $upload->saveRule = 'uniqid';

         if (!$upload->upload()) {
            //捕获上传异常
            $this->error($upload->getErrorMsg());
         } else {
            $uploadList = $upload->getUploadFileInfo();
         }

         return $uploadList;
    }

    /**
     * 得到图片路径
     * @return array
     */
    private function getImagesPath($uploadList) {
        $imgs = array();
        foreach ($uploadList as $upload) {
            $imgs[] = $upload['savename'];
        }

        return $imgs;
    }

    /**
     * 
     * @param string $goodsId 
     * @param array  $imgs
     */
    private function addGoodsImages($goodsId, array $imgs) {
        // 插入展示图片
        $GoodsImages = M('GoodsImages');
        $image['goods_id'] = $goodsId;
        foreach ($imgs as $img) {
            $image['path'] = $img;
            $GoodsImages->add($image);
        }        
    }

    /**
     * 分页
     * @param  string $model
     * @return 
     */
    protected function pagination($model, $categoryId) {
        $service = D($model, 'Service');

        $totalCount = $service->getCount($categoryId);
        $page = new \Org\Util\Page($totalCount, C('PAGINATION_NUM'));
        $result['show'] = $page->show();

        $data = $service->getPagination($page->firstRow, 
                                        $page->listRows,
                                        $categoryId);
        $result['data'] = $data;

        return $result;
    }    
}
