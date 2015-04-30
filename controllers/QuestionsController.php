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

    public function index() {
        $this->questions = $this->db->getAll();
        $this->renderView();
    }

    public function view($id) {
        $this->questionWithAnswers = $this->db->getByIdWithAnswer($id);
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