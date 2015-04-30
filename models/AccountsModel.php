<?php
/**
 * Created by PhpStorm.
 * User: Vesko
 * Date: 30/04/2015
 * Time: 13:59
 */

class AccountsModel extends BaseModel {

    public function register($username, $password, $email, $fullName){
        $statement = self::$db->prepare("SELECT COUNT(Id) FROM users WHERE Username =  ?");
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();
        if($result['COUNT(Id)'] != 0){
            return false;
        }
        $hash_password = password_hash($password, PASSWORD_BCRYPT);
        $registerStatement = self::$db->prepare("
            INSERT INTO users (Username, Password, Email, FullName, IsAdmin)
            VALUES (?, ?, ?, ?, 0)");
        $registerStatement->bind_param("ssss", $username, $hash_password,$email,$fullName);
        $registerStatement->execute();
        return true;
    }

    public function login($username, $password){
        $statement = self::$db->prepare("SELECT * FROM users WHERE Username =  ?");
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();
        if(password_verify($password, $result['Password'])){
            return true;
        }

        return false;
    }
}