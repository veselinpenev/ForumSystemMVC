<?php

class CategoriesModel extends BaseModel {

    public function getAll() {
        $data = self::$db->query("SELECT * FROM categories ORDER BY Id");
        return $data->fetch_all(MYSQL_ASSOC);
    }

    public function getMaxCount(){
        $data = self::$db->query("SELECT COUNT(Id) as maxCount FROM categories ");
        return $data->fetch_all(MYSQL_ASSOC);
    }

    public function getAllWithPage($from, $pageSize){
        $statement = self::$db->prepare("SELECT * FROM categories ORDER BY Id LIMIT ?, ?");
        $statement->bind_param('ii', $from, $pageSize);
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQL_ASSOC);
    }
}