<?php

class AnswersModel extends BaseModel {
    public function add($questionId, $content, $authorName, $authorEmail){
        $query = sprintf(
            "INSERT INTO answers(Content, Date, Question, AuthorName, AuthorEmail)
            VALUES ('%s', NOW(), %s, '%s', '%s')",
            $content, $questionId, $authorName, $authorEmail);
        $data = self::$db->query($query);
        $answerId = self::$db->insert_id;

        if($answerId > 0){
            return true;
        }
        return false;

    }
}