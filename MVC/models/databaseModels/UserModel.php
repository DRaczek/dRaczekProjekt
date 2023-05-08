<?php
class UserModel{
    public function __construct(){

    }

    public function registerUser($email, $firstName, $lastName, $dateOfBirth, $password, $user_id){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "INSERT INTO users(email, password, first_name, last_name, date_of_birth, created_date, user_id_created, last_modified_date, user_id_last_modified, status) ";
        $query .= "VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $dbh->prepare($query);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([
            $email,
            $password,
            $firstName,
            $lastName,
            $dateOfBirth,
            (new DateTime())->format('Y-m-d H:i:s'),
            $user_id,
            (new DateTime())->format('Y-m-d H:i:s'),
            $user_id,
            (int)StatusEnum::INACTIVE]);
        $stmt = $dbh->prepare("SELECT id, email FROM users WHERE email= ? ");
        $stmt->execute([$email]);
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $dbh = null;
        return $result;
    }

    public function activateUser($user_id){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $acitveStatus = (int)StatusEnum::ACTIVE;
        $query = "UPDATE users SET status = ? WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$acitveStatus, $user_id]);
        $dbh = null;
    }

    public function isEmailTaken($email){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$email]);
        $count = ($stmt->fetch())[0];
        $dbh = null;
        if($count>0){
            return true;
        }
        else{
            return false;
        }
        
    }

    public function loginUser($email){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT id, first_name, email, password FROM users WHERE email = ? AND status = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$email, (int)StatusEnum::ACTIVE]);
        $dbh = null;
        return $stmt->fetch();
    }

    public function getActiveUserIdByEmail($email){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT id, email FROM users WHERE email = ? AND status = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$email, (int)StatusEnum::ACTIVE]);
        $dbh = null;
        return $stmt->fetch();
    }

    public function resetUserPassword($user_id, $password){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([$password, $user_id]);
        $dbh = null;
    }

    public function getUser($userId){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "SELECT email, first_name, last_name, date_of_birth FROM users WHERE id = ? AND status = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$userId, (int)StatusEnum::ACTIVE]);
        $dbh = null;
        return $stmt->fetch();
    }

    public function editUser($firstName, $lastName, $dateOfBirth, $userId){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query = "UPDATE users SET first_name = ?, last_name = ?, date_of_birth = ?, user_id_last_modified = ?, last_modified_date = ? WHERE id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$firstName, $lastName, $dateOfBirth, $userId, (new DateTime())->format('Y-m-d H:i:s'), $userId]);
        $dbh = null;
    }

    public function isAdmin($userId){
        $dbh = include("MVC/models/databaseModels/Database.php");
        $query ="SELECT COUNT(id) FROM users_admin WHERE user_id = ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$userId]);
        $dbh = null;
        if($stmt->fetch()[0]>0){
            return true;
        }
        return false;
    }
}