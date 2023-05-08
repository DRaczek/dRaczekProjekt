<?php 
include_once("MVC/controllers/admin/order/AdminOrderController.php");
include_once("MVC/models/databaseModels/AdminOrderModel.php");

class ManageOrderStateController extends AdminOrderController{
    public function __construct(){

    }
    public function suspendOrder($id){
        $this->RedirectIfAdminNotLoggedIn();
        $adminOrderModel = new AdminOrderModel();
        $location="../../orders".((isset($_COOKIE['admin_order_pageable']))?"?".$_COOKIE['admin_order_pageable']:"");
        try{
            $adminOrderModel->suspendOrder($id, $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się zaktualizować danych zamówienia";
            header("Location:$location");
            exit();
        }
        $_SESSION['message'] = "Poprawnie zmieniono status zamówienia";
        header("Location:$location");
    }

    public function activateOrder($id){
        $this->RedirectIfAdminNotLoggedIn();
        $adminOrderModel = new AdminOrderModel();
        $location="../../orders".((isset($_COOKIE['admin_order_pageable']))?"?".$_COOKIE['admin_order_pageable']:"");
        try{
            $adminOrderModel->activateOrder($id, $_SESSION['user_id']);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się zaktualizować danych zamówienia";
            header("Location:$location");
            exit();
        }
        $_SESSION['message'] = "Poprawnie zmieniono status zamówienia";
        header("Location:$location");
    }

    public function deleteOrder($id){
        $this->RedirectIfAdminNotLoggedIn();
        $adminOrderModel = new AdminOrderModel();
        $location="../../orders".((isset($_COOKIE['admin_order_pageable']))?"?".$_COOKIE['admin_order_pageable']:"");
        try{
            $path = $adminOrderModel->deleteOrder($id);
        }
        catch(Exception $e){
            $_SESSION['message'] = "Nie udało się usunąć zamówienia";
            header("Location:$location");
            exit();
        }
        $_SESSION['message'] = "Poprawnie usunięto zamówienie";
        header("Location:$location");
    }
}