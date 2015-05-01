<?php
/**
 * Created by PhpStorm.
 * User: Vesko
 * Date: 29/04/2015
 * Time: 20:22
 */

class QuestionsController extends BaseController{
    private $db;
    public function onInit(){
        $this->title = "Questions";
        $this->db = new QuestionsModel();
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

        $this->questions = $this->db->getAllWithPage($from, $pageSize);
        $this->renderView();
    }

    public function view($questionId, $page = 1, $pageSize = 5) {
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->questionId = $questionId;
        $page = $page-1;
        $all = $this->db->getMaxCountAnswer($questionId);
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


        $this->questionWithAnswers = $this->db->getByIdWithAnswer($questionId, $from, $pageSize);
        $this->renderView(__FUNCTION__);
    }



    public function add() {
        $this->authorize();

        if($this->isPost) {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $categoryId = $_POST['selectCategory'];
            $tags = $_POST['check_tags'];

            $questionId = $this->db->add($title, $content, $categoryId, $tags);

            if($questionId){
                $this->addSuccessMessage("Added successful question");
                $this->redirectToUrl("/questions/view/$questionId");
            }

        } else {
            $this->TagsAndCategories = $this->db->getAllTagsAndCategories();
            $this->renderView(__FUNCTION__);
        }
    }
}