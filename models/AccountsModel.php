<?php
/**
 * Created by PhpStorm.
 * User: Vesko
 * Date: 30/04/2015
 * Time: 13:59
 */

class AccountsModel extends BaseModel {

    public function register($username, $password, $email, $fullName){
        $query = sprintf("SELECT COUNT(Id) FROM users WHERE Username =  '%s'",
            $username);
        $data = self::$db->query($query);
        $result = $this->process_results($data);
        if($result['COUNT(Id)'] != 0){
            return false;
        }
        $hash_password = password_hash($password, PASSWORD_BCRYPT);
        $queryInsert = sprintf(
            "INSERT INTO users (Username, Password, Email, FullName, IsAdmin)
            VALUES ('%s', '%s', '%s', '%s', 0)",
            $username, $hash_password,$email,$fullName);
        $dataInsert = self::$db->query($queryInsert);
        $userId = self::$db->insert_id;
        if($userId > 0){
            return true;
        } else {
            return false;
        }
    }

    public function login($username, $password){
        $query = sprintf("SELECT * FROM users WHERE Username =  '%s'",
            $username);
        $data = self::$db->query($query);
        $result = $this->process_results($data);
        if(password_verify($password, $result[0]['Password'])){
            return true;
        }
        return false;
    }

    public function editProfile($username, $fullName, $email){
        $query = sprintf("UPDATE users SET FullName= '%s', Email = '%s' WHERE Username = '%s'",
            $fullName, $email, $username);
        $data = self::$db->query($query);
        $result = self::$db->affected_rows;
        if($result > 0){
            return true;
        }
        return false;
    }

    public function editPassword($username, $oldPassword, $newPassword){
        $query = sprintf("SELECT Password FROM users WHERE Username =  '%s'",
            $username);
        $data = self::$db->query($query);
        $result = $this->process_results($data);

        if(password_verify($oldPassword, $result[0]['Password'])){
            $pass_hash = password_hash($newPassword, PASSWORD_BCRYPT);
            $queryEdit = sprintf("UPDATE users SET Password= '%s' WHERE Username = '%s'",
                $pass_hash, $username);
            $dataEdit = self::$db->query($queryEdit);
            $resultEdit = self::$db->affected_rows;
            if($resultEdit > 0){
                return true;
            }
        }
        return false;
    }

    public function getInfo($username){
        $query = sprintf("Select Id, Username, Email, FullName from users WHERE Username =  '%s'",
            $username);
        $data = self::$db->query($query);
        $result = $this->process_results($data);

        if($result[0]['Id'] == 0){
            return false;
        }

        return $result[0];
    }
}