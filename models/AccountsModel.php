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

    public function editProfile($username, $fullName, $email){
        $statement = self::$db->prepare("UPDATE users SET FullName= ?, Email = ? WHERE Username = ?");
        $statement->bind_param("sss", $fullName, $email, $username);
        $statement->execute();
        $result = $statement->affected_rows;
        if($result > 0){
            return true;
        }
        return false;
    }

    public function editPassword($username, $oldPassword, $newPassword){
        $statement = self::$db->prepare("SELECT Password FROM users WHERE Username =  ?");
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();
        if(password_verify($oldPassword, $result['Password'])){
            $pass_hash = password_hash($newPassword, PASSWORD_BCRYPT);
            $editStatement = self::$db->prepare("UPDATE users SET Password= ? WHERE Username = ?");
            $editStatement->bind_param("ss", $pass_hash, $username);
            $editStatement->execute();
            $resultEdit = $editStatement->affected_rows;
            if($resultEdit > 0){
                return true;
            }
        }
        return false;
    }

    public function getInfo($username){
        $statement = self::$db->prepare("Select Id, Username, Email, FullName from users WHERE Username =  ?");
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();

        if($result['Id'] == 0){
            return false;
        }

        return $result;
    }
}