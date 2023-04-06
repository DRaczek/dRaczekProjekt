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

    /**
     * Admin auth.
     */

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

    /**
     * Admin Panel.
     */

    public function displayAdminHomePage(){
        $this->checkIfLoggedInAndRedirect();
        include("MVC/views/admin/homePage.php");
    }

    /**
     * User management.
     */

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

    /**
     * Category management.
     */
    public function displayManageCategoriesPage($pageable = "page=1&size=10"){
        $this->checkIfLoggedInAndRedirect();
        // pobiera z $_POST i tworzy URL rozpoznawalne przez Router
        setcookie("category_pageable", $pageable, time()+1*60*60);
        if(isset($_POST['name']) 
        || isset($_POST['status'])
        || isset($_POST['created_date'])){

            $uri = $_SERVER['REQUEST_URI'];
            if(!empty($_POST['name'])){
                $uri.="&name=".$_POST['name'];
            }
            // z jakiegos powodu jezeli status=0 to empty() zwraca true
            if($_POST['status']==0 || !empty($_POST['status'])){
                $uri.="&status=".$_POST['status'];
            }
            if(!empty($_POST['created_date'])){
                $uri.="&createdDate=".$_POST['created_date'];
            }
            if(!empty($_POST['id'])){
                $uri.="&id=".$_POST['id'];
            }
            if(!empty($_POST['orderBy'])){
                $uri.="&orderBy=".$_POST['orderBy'];
            }
            if(!empty($_POST['order'])){
                $uri.="&order=".$_POST['order'];
            }
            header("Location:$uri");
            exit();
        }

        //Pobiera dane z URL
        parse_str($pageable, $params);

        $page = intval($params['page']);
        $pageSize = intval($params['size']);
        $name= null;
        $status = null;
        $createdDate = null;
        $orderBy = null;
        $order = null;
        $id=null;
     
        if(isset($params['name'])){
            $name = $params['name'];
        }
        if(isset($params['status'])){
            $status = intval($params['status']);
        }
        if(isset($params['createdDate'])){
            $createdDate = $params['createdDate'];
        }
        if(isset($params['id'])){
            $id = $params['id'];
        }
        if(isset($params['orderBy'])){
            $orderBy = $params['orderBy'];
        }
        if(isset($params['order'])){
            $order = $params['order'];
        }

        //jezeli orderBy niepoprawne to ustawi się domyślne
        $AcceptableOrderByArray = array(
            "created_date",
            "id",
            "status",
            "name");
        if(!in_array($orderBy, $AcceptableOrderByArray)){
            $orderBy = $AcceptableOrderByArray[0];
        }
        $AcceptableOrderArray = array(
            "desc",
            "asc");
        if(!in_array($order, $AcceptableOrderArray)){
            $order = $AcceptableOrderArray[0];
        }
        
        $firstResult = ($page - 1) * $pageSize;

        $adminModel = new AdminModel();
        //wyszukiwanie ze specyfikacją
        if($status==999)$status=null; //czyli ze wszystkie statusy
        $result = $adminModel->searchCategories($firstResult, $pageSize, $id, $name, $status, $createdDate, $orderBy, $order);
        $resultCount = ($adminModel->searchCategoriesCount( $name, $status, $createdDate))[0];
        include("MVC/views/admin/menageCategoriesPage.php");
    }

    public function displayAddCategoryPage(){
        $this->checkIfLoggedInAndRedirect();
        include("MVC/views/admin/addCategoryPage.php");
    }

    public function addCategory(){
        $this->checkIfLoggedInAndRedirect();
        if(!isset($_FILES['image'])
        || !isset($_POST['submit'])
        || !isset($_POST['name'])){
            $_SESSION['message'] = "Nie wszystkie pola zostały przesłane.";
            header("Location:../add");
            exit();
        }
        $adminModel = new AdminModel();
        if($adminModel->isCategoryNameTaken($_POST['name'])){
            $_SESSION['message'] = "Kategoria o podanej nazwie już istnieje";
            header("Location:../add");
            exit();
        }

        $fileValidationHelper = new FileUploadValidationHelper();
        try{
            $targetFile = $fileValidationHelper->validateImage($_FILES['image'], "img/uploads/categories/");
        }
        catch(Exception $e){
            $_SESSION['message'] = $e->getMessage();
            header("Location:../add");
            exit();
        }
        if(!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)){
            $_SESSION['message'] = "Nie udało się zapisać pliku.";
            header("Location:../add");
            exit();
        }
       
        try{
            $adminModel->createCategory($_POST['name'], $targetFile, $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się dodać wpisu do bazy danych.";
        }
        $_SESSION['message'] = "Poprawnie dodano kategorię.";
        header("Location:../add");
    }

    public function suspendCategory($id){
        $this->checkIfLoggedInAndRedirect();
        $adminModel = new AdminModel();
        $location="../../categories".((isset($_COOKIE['category_pageable']))?"/".$_COOKIE['category_pageable']:"");
        try{
            $adminModel->suspendCategory($id, $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się zaktualizować danych kategorii";
            header("Location:$location");
            exit();
        }
        $_SESSION['message'] = "Poprawnie zmieniono status kategorii";
        header("Location:$location");
        
    }

    public function activateCategory($id){
        $this->checkIfLoggedInAndRedirect();
        $adminModel = new AdminModel();
        $location="../../categories".((isset($_COOKIE['category_pageable']))?"/".$_COOKIE['category_pageable']:"");
        try{
            $adminModel->activateCategory($id, $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się zaktualizować danych kategorii";
            header("Location:$location");
            exit();
        }
        $_SESSION['message'] = "Poprawnie zmieniono status kategorii";
        header("Location:$location");
    }

    public function deleteCategory($id){
        $this->checkIfLoggedInAndRedirect();
        $adminModel = new AdminModel();
        $location="../../categories".((isset($_COOKIE['category_pageable']))?"/".$_COOKIE['category_pageable']:"");
        try{
            $path = $adminModel->deleteCategory($id);
            if(file_exists($path)){
                unlink($path);
            }
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się usunąć kategorii";
            header("Location:$location");
            exit();
        }
        $_SESSION['message'] = "Poprawnie usunięto kategorię";
        header("Location:$location");
    }

    public function displayEditCategoryPage($id){
        include("MVC/views/admin/editCategoryPage.php");
    }

    public function editCategory(){
        $this->checkIfLoggedInAndRedirect();

        if(!isset($_FILES['image'])
        || !isset($_POST['submit'])
        || !isset($_POST['name'])
        || !isset($_POST['id'])){
            $_SESSION['message'] = "Nie wszystkie pola zostały przesłane.";
            header("Location:../edit/form/$id");
            exit();
        }
        $id = intval($_POST['id']);
        $adminModel = new AdminModel();
        if($adminModel->isCategoryNameTaken($_POST['name'], $id)){
            $_SESSION['message'] = "Kategoria o podanej nazwie już istnieje";
            header("Location:../edit/form/$id");
            exit();
        }

        $fileValidationHelper = new FileUploadValidationHelper();
        try{
            $targetFile = $fileValidationHelper->validateImage($_FILES['image'], "img/uploads/categories/");
        }
        catch(Exception $e){
            $_SESSION['message'] = $e->getMessage();
            header("Location:../edit/form/$id");
            exit();
        }

        if(!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)){
            $_SESSION['message'] = "Nie udało się zapisać pliku.";
            header("Location:../edit/form/$id");
            exit();
        }
       
        try{
            $oldImg = $adminModel->editCategory($_POST['name'], $targetFile, $_SESSION['user_id'], $id);
            if(file_exists($oldImg)){
                unlink($oldImg);
            }
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się dodać wpisu do bazy danych.";
        }
        $_SESSION['message'] = "Poprawnie zmieniono kategorię.";
        header("Location:../edit/form/$id");
    }
}