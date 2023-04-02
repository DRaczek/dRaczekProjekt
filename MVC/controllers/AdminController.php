<?php

class AdminController{
    public function __construct(){

    }

    public function checkIfLoggedInAndRedirect(){
        if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_is_admin']) || $_SESSION['user_is_admin']===false){
            header("Location:../home");
            exit();
        }
    }

    public function displayLoginAdminPage(){
        if(isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']===true)header("Location:home");
        include("MVC/views/admin/loginPage.php");
    }

    public function loginAdmin(){
        if(isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']===true)header("Location:../home");

        if(!isset($_POST['submit']) || !isset($_POST['email']) || !isset($_POST['password'])){
            $_SESSION['message'] = "Nie wszystkie dane zostały przesłane.";
            header("Location:../login");
            exit();
        }
        if(empty($_POST['email']) || empty($_POST['password'])){
            $_SESSION['message'] = "Nie wszystkie pola zostały uzupełnione.";
            header("Location:../login");
            exit();
        }
        $email = $_POST['email'];
        $password = $_POST['password'];
        $adminModel = new AdminModel();
        $user = $adminModel->loginAdmin($email);
        if($user==null){
            $_SESSION['message'] = "Konto o podanych danych, nie istnieje";
            header("Location:../login");
            exit();
        }
        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_first_name'] = $user['first_name'];
            $_SESSION['user_is_admin'] = true;
            header("Location:../home");
        }
        else{
            $_SESSION['message'] = "Wystąpił błąd";
            header("Location:../login");
        }
    }

    public function displayAdminHomePage(){
        $this->checkIfLoggedInAndRedirect();
        include("MVC/views/admin/homePage.php");
    }

    public function displayManageUsersPage($pageable = "page=1&size=10"){
        $this->checkIfLoggedInAndRedirect();

        // obsłga funkcji wyszukiwania
        // pobiera z $_POST i tworzy URL rozpoznawalne przez Router
        if(isset($_POST['email']) 
        || isset($_POST['first_name'])
        || isset($_POST['last_name'])
        || isset($_POST['status'])
        || isset($_POST['created_date'])){

            $uri = $_SERVER['REQUEST_URI'];
            if(!empty($_POST['email'])){
                $uri.="&email=".$_POST['email'];
            }
            if(!empty($_POST['first_name'])){
                $uri.="&firstName=".$_POST['first_name'];
            }
            if(!empty($_POST['last_name'])){
                $uri.="&lastName=".$_POST['last_name'];
            }
            if(!empty($_POST['status'])){
                $uri.="&status=".$_POST['status'];
            }
            if(!empty($_POST['created_date'])){
                $uri.="&createdDate=".$_POST['created_date'];
            }
            header("Location:$uri");
            exit();
        }

        //Pobiera dane z URL
        parse_str($pageable, $params);

        $page = intval($params['page']);
        $pageSize = intval($params['size']);
        $email= null;
        $firstName = null;
        $lastName = null;
        $status = null;
        $createdDate = null;
        if(isset($params['email'])){
            $email = $params['email'];
        }
        if(isset($params['firstName'])){
            $firstName = $params['firstName'];
        }
        if(isset($params['lastName'])){
            $lastName = $params['lastName'];
        }
        if(isset($params['status'])){
            $status = $params['status'];
        }
        if(isset($params['createdDate'])){
            $createdDate = $params['createdDate'];
        }

        $firstResult = ($page - 1) * $pageSize;

        $adminModel = new AdminModel();
        //wyszukiwanie ze specyfikacją
        $result = $adminModel->searchUsers($firstResult, $pageSize, $email, $firstName, $lastName, $status, $createdDate);
        $resultCount = ($adminModel->searchUsersCount($email, $firstName, $lastName, $status, $createdDate))[0];

        include("MVC/views/admin/manageUsersPage.php");
    }

    public function suspendUser($id){
        $this->checkIfLoggedInAndRedirect();
        $adminModel = new AdminModel();
        try{
            $adminModel->suspendUser($id, $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się zaktualizować danych użytkownika";
            header("Location:../../users");
            exit();
        }
        $_SESSION['message'] = "Poprawnie zmieniono status użytkownika";
        header("Location:../../users");
        
    }

    public function activateUser($id){
        $this->checkIfLoggedInAndRedirect();
        $adminModel = new AdminModel();
        try{
            $adminModel->activateUser($id, $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się zaktualizować danych użytkownika";
            header("Location:../../users");
            exit();
        }
        $_SESSION['message'] = "Poprawnie zmieniono status użytkownika";
        header("Location:../../users");
    }
}