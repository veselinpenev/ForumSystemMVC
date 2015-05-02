<?php

class CategoriesController extends BaseController
{
    private $db;

    public function onInit()
    {
        $this->db = new CategoriesModel();
        $this->title = "Categories";
    }

    public function index($page = 1, $pageSize = 5) {
        $this->page = $page;
        $this->pageSize = $pageSize;
        $page = $page-1;
        $all = $this->db->getMaxCount();
        $maxCount = $all[0]['maxCount'];
        $maxPage = floor($maxCount/$pageSize);
        if($maxCount%$pageSize>0){
            $maxPage++;
        }
        $from = $page * $pageSize;
        if($page > $maxPage){
            $page=$maxPage;
        }
        if($page < 0){
            $page = 0;
        }
        $this->maxPage=$maxPage;

        $this->categories = $this->db->getAllWithPage($from, $pageSize);
        $this->renderView();
    }
}