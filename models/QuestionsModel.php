<?php

class QuestionsModel extends BaseModel {
    public function getAll(){
        $data = self::$db->query("SELECT
                                    q.Id,
                                    q.Title,
                                    q.Date,
                                    q.Counter,
                                    c.Title as Category,
                                    u.Username
                                FROM questions q
                                left join categories c on q.Category=c.Id
                                left join users u on q.User=u.Id
                                ORDER BY Date DESC"
        );
        return $data->fetch_all(MYSQL_ASSOC);
    }

    public function getMaxCount(){
        $data = self::$db->query("SELECT COUNT(q.Id) as maxCount
                                FROM questions q
                                left join categories c on q.Category=c.Id
                                left join users u on q.User=u.Id
                                ORDER BY Date DESC"
        );
        return $data->fetch_all(MYSQL_ASSOC);
    }

    public function getAllWithPage($from, $pageSize){
        $statement = self::$db->prepare("SELECT
                                    q.Id,
                                    q.Title,
                                    q.Date,
                                    q.Counter,
                                    c.Title as Category,
                                    u.Username
                                FROM questions q
                                left join categories c on q.Category=c.Id
                                left join users u on q.User=u.Id
                                ORDER BY Date DESC
                                LIMIT ?, ?"
        );
        $statement->bind_param('ii', $from, $pageSize);
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQL_ASSOC);
    }

    public function getMaxCountAnswer($id){
        $data = self::$db->prepare("SELECT COUNT(a.Id) as maxCount
                                FROM questions q
                                left join categories c on q.Category=c.Id
                                left join users u on q.User=u.Id
                                left join answers a on a.Question = q.Id
                                where q.id = ?"
        );
        $data->bind_param('i', $id);
        $data->execute();
        return $data->get_result()->fetch_all(MYSQL_ASSOC);
    }

    public function getByIdWithAnswer($id, $from, $pageSize){

        $updateStatement = self::$db->prepare(
            "Update questions Set Counter = Counter + 1 Where Id = ?");
        $updateStatement->bind_param("i", $id);
        $updateStatement->execute();


        $questionStatement = self::$db->prepare(
            "SELECT
                q.Id,
                q.Title,
                q.Date,
                q.Counter,
                q.Content,
                c.Title as Category,
                u.Username,
                a.Content as AnswerContent,
                a.Date as AnswerDate,
                a.AuthorName as AnswerAuthor,
                a.AuthorEmail as AnswerAuthorEmail
            FROM questions q
            left join categories c on q.Category=c.Id
            left join users u on q.User=u.Id
            left join answers a on a.Question = q.Id
            where q.id = ?
            LIMIT ?, ?");
        $questionStatement->bind_param("iii", $id, $from, $pageSize);
        $questionStatement->execute();
        $dataWithTags = $questionStatement->get_result()->fetch_all(MYSQL_ASSOC);

        $tagsStatement = self::$db->prepare(
            "SELECT
                group_concat(' ', t.Title) as Tags
            FROM questions q
            left join questions_tags qt on q.Id = qt.questionId
            left join tags t on qt.tagId = t.Id
            where q.id = ?");
        $tagsStatement->bind_param("i", $id);
        $tagsStatement->execute();
        $tagsFetch = $tagsStatement->get_result()->fetch_all(MYSQL_ASSOC);

        $dataWithTags[0]['Tags'] = $tagsFetch[0]['Tags'];
        return $dataWithTags;

    }

    public function getAllTagsAndCategories(){
        $categories = self::$db->query("SELECT * FROM categories");
        $categoriesFetch = $categories->fetch_all(MYSQL_ASSOC);

        $tags = self::$db->query("SELECT * FROM tags");
        $tagsFetch = $tags->fetch_all(MYSQL_ASSOC);

        $union = array();
        $union['categories'] = $categoriesFetch;
        $union['tags'] = $tagsFetch;

        return $union;

    }

    public function add($title, $content, $categoryId, $tags){
        $userStatement = self::$db->prepare("SELECT Id FROM users WHERE username = ?");
        $userStatement->bind_param("s", htmlspecialchars($_SESSION['username']));
        $userStatement->execute();
        $user = $userStatement->get_result()->fetch_all(MYSQL_ASSOC);
        $userId = $user[0]['Id'];

        $questionStatement = self::$db->prepare("
            INSERT INTO questions (Title, Content, Date, Counter, Category, User)
            VALUES (?, ?, NOW(), ? ,? ,?)");
        $questionStatement->bind_param("ssiii", $title, $content, $c = 0, $categoryId, $userId);
        $questionStatement->execute();
        $questionId = $questionStatement->insert_id;

        if($questionId > 0){
            foreach ($tags as $tag) {
                $questionStatement = self::$db->prepare("
                    INSERT INTO questions_tags (questionId, tagId)
                    VALUES (?,?)");
                $questionStatement->bind_param("ii", $questionId, $tag);
                $questionStatement->execute();
            }
        }
        else{
            return false;
        }

        return $questionId;

    }
}