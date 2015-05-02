<?php

class AnswersModel extends BaseModel {
    public function add($questionId, $content, $authorName, $authorEmail){
               
        $answerStatement = self::$db->prepare(
            "INSERT INTO answers(Content, Date, Question, AuthorName, AuthorEmail)
            VALUES (?, NOW(), ?, ?, ?)");
        $answerStatement->bind_param("siss", $content, $questionId, $authorName, $authorEmail);
        $answerStatement->execute();
        $answerId = $answerStatement->insert_id;

        if($answerId > 0){
            return true;
        }
        return false;

    }
}