<?php
include_once("MVC/models/databaseModels/AdminCategoryModel.php");

class DeleteCategoryValidationHelper{
    public function __construct(){

    }

    public function validate($id){
        // sprawdzic czy sa przypisane produkty
        $violations = array();
        $adminCategoryModel = new AdminCategoryModel();
        $count = $adminCategoryModel->getProdutsCount($id);
        if($count>0){
            array_push($violations, "Nie można usunąć tej kategorii, ponieważ są do niej przypisane produkty. Zmień kategorie powiązanych produktów lub je usuń, aby móc usunąć tą kategorię.");
        }
        if(count($violations)>0){
            throw new Exception(implode(" ", $violations));
        }
    }
}