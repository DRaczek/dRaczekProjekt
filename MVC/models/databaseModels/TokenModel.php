<?php

class TokenModel{
    public function __construct(){

    }
    public function saveToken($token, $action, $user_id, $user_id_created){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $stmt = $dbh->prepare("INSERT INTO users_token_action (token, action, user_id, created_date, user_id_created, last_modified_date, user_id_last_modified, status) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->execute([
            $token,
            $action,
            $user_id,
            (new DateTime())->format('Y-m-d H:i:s'), 
            $user_id_created, (new DateTime())->format('Y-m-d H:i:s'), 
            $user_id_created, (int)StatusEnum::ACTIVE]);
        $dbh = null;
    }
    public function checkToken($token){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $stmt = $dbh->prepare("SELECT action, user_id FROM users_token_action where token = ?");
        $stmt->execute([$token]);
        $dbh = null;
        if($stmt->rowCount()>0){
            return $stmt->fetch();
        }
        else{
            return false;
        }
    }
    public function deleteToken($token){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $stmt = $dbh->prepare("DELETE FROM users_token_action WHERE token = ?");
        $stmt->execute([$token]);
        $dbh = null;
    }
}