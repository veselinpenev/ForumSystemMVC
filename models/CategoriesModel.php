<?php

class CategoriesModel extends BaseModel {

    public function getAll() {
        $data = self::$db->query("SELECT * FROM categories ORDER BY Id");
        return $this->process_results($data);
    }

    public function getMaxCount(){
        $data = self::$db->query("SELECT COUNT(Id) as maxCount FROM categories ");
        return $this->process_results($data);
    }

    public function getAllWithPage($from, $pageSize){
        $query = sprintf("SELECT * FROM categories ORDER BY Id LIMIT %s, %s",
            $from, $pageSize);
        $data = self::$db->query($query);
        return $this->process_results($data);

    }
}