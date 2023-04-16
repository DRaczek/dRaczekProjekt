<?php
include_once("MVC/controllers/admin/user/AdminController.php");
include_once("MVC/models/databaseModels/AdminModel.php");

class ManageUsersStateController extends AdminController{
    public function __construct(){
        
    }

    public function suspendUser($id){
        $this->RedirectIfAdminNotLoggedIn();
        $adminModel = new AdminModel();
        $location="../../users".((isset($_COOKIE['admin_users_pageable']))?"?".$_COOKIE['admin_users_pageable']:"");
        try{
            $adminModel->suspendUser($id, $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się zaktualizować danych użytkownika";
            header("Location:$location");
            exit();
        }
        $_SESSION['message'] = "Poprawnie zmieniono status użytkownika";
        header("Location:$location");
        
    }

    public function activateUser($id){
        $this->RedirectIfAdminNotLoggedIn();
        $adminModel = new AdminModel();
        $location="../../users".((isset($_COOKIE['admin_users_pageable']))?"?".$_COOKIE['admin_users_pageable']:"");
        try{
            $adminModel->activateUser($id, $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się zaktualizować danych użytkownika";
            header("Location:$location");
            exit();
        }
        $_SESSION['message'] = "Poprawnie zmieniono status użytkownika";
        header("Location:$location");
    }
}