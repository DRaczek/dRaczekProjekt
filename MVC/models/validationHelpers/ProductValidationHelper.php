<?php
include_once("MVC/models/validationHelpers/FileUploadValidationHelper.php");
include_once("MVC/models/databaseModels/AdminProductModel.php");
include_once("MVC/models/databaseModels/AdminCategoryModel.php");

class ProductValidationHelper{
    public function __construct(){

    }

    public function validate(){
        $violations = array();
        $targetFiles = null;
        if(!isset($_POST['submit'])
        || !isset($_POST['name'])
        || !isset($_POST['category'])
        || !isset($_FILES['image_1'])
        || !isset($_FILES['image_2'])
        || !isset($_FILES['image_3'])
        || !isset($_POST['description'])
        || !isset($_POST['price'])
        || !isset($_POST['quantity'])
        || !isset($_POST['size'])
        || !isset($_POST['colour'])
        || !isset($_POST['id'])){
            array_push($violations, "Nie wszystkie pola zostały przesłane<br>");
        }
        else{
            $this->validateName($_POST['name'], $violations, $_POST['id']);
            $this->validateCategory($_POST['category'], $violations);
            $targetFiles = $this->validateImages(
                [$_FILES['image_1'], $_FILES['image_2'], $_FILES['image_3']],
                $violations);
            $this->validateDescription($_POST['description'], $violations);
            $this->validatePrice($_POST['price'], $violations);
            $this->validateQuantity($_POST['quantity'], $violations);
            $this->validateSize($_POST['size'], $violations);
            $this->validateColour($_POST['colour'], $violations);
        }
        if(count($violations)>0){
            throw new Exception(implode(" ", $violations));
            return null;
        }
        else{
            return $targetFiles;
        }
    }

    private function validateName($name, &$violations, $id=null){
        try{
            $adminProductModel = new AdminProductModel();
            if($adminProductModel->isProductNameTaken($name, $id)){
                array_push($violations,"Nazwa produku jest już zajęta!<br>");     
            }
            if (!preg_match('/^[a-zA-Z\d\s]{2,250}$/', $name)) {
                array_push($violations, "Podana nazwa jest niepoprawna. Dozwolone są tylko litery i spacja. Długośc powinna wynosić od 2 do 250 znaków.<br>");
            }
        }
        catch(Exception $e){
            array_push($violations,"Nazwa produku jest nieporawna!<br>");
        }
    }

    private function validateCategory($categoryName, &$violations){
        $adminCategoryModel = new AdminCategoryModel();
        if(!$adminCategoryModel->isCategoryNameTaken($categoryName)){
            array_push($violations,"Podana kategoria nie istnieje!<br>");
        }
    }

    private function validateImages($images, &$violations){
        $targetFiles = array();
        $fileValidationHelper = new FileUploadValidationHelper();
        try{
            if(!is_array($images)){
                array_push($violations,"Przesłane dane są nieprawidłowe. <br>");
            }
            else if(count($images)!==3){
                array_push($violations, "Przesłane dane są nieprawidłowe. <br>");
            }
            else if($images[0]['error']!==0){
                array_push($violations, "Pierwsze zdjęcie musi być podane. <br>");
            }
            else{
                if(($images[0]['name']==$images[1]['name'] && $images[0]['error']!==4 && $images[1]['error']!==4) 
                || ($images[0]['name']==$images[2]['name'] && $images[0]['error']!==4 && $images[2]['error']!==4)
                || ($images[1]['name']==$images[2]['name'] && $images[1]['error']!==4 && $images[2]['error']!==4)){
                    array_push($violations, "Nazwy przesłanych zdjęć muszą być różne. <br>");
                }
            }
        
            foreach($images as $image){
                //4 - czyli nie wybrany żaden
                if($image['error']===4)continue;
                try{
                    $targetFile = $fileValidationHelper->validateImage($image, "img/uploads/products/");
                    array_push($targetFiles, ["tmp_name" => $image['tmp_name'] , "name" => $targetFile]);
                }
                catch(Exception $e){
                    array_push($violations, $e->getMessage());
                }        
            }

            
            
        }
        catch(Exception $exception){
            array_push($violations,"Przesłane zdjęcia są nieprawidłowe.<br>");
        }
        return $targetFiles;
    }

    private function validateDescription($description, &$violations){
        if (!preg_match('/^[a-zA-Z0-9.,:;"\'() \n-]*$/', $description)) {
            array_push($violations,"Podany opis jest nieprawidłowy.<br>");
        }
    }

    private function validatePrice($price, &$violations){
        if(!filter_var($price, FILTER_VALIDATE_FLOAT)){
            array_push($violations,"Przesłana cena nie jest poprawną liczbą.<br>");
        }
        if($price<0){
            array_push($violations,"Cena nie może być ujemna.<br>");
        }
        if($price>1000000){
            array_push($violations,"Cena musi być mniejsza od 1 000 000 PLN.<br>");
        }
    }

    private function validateQuantity($quantity, &$violations){
        if(!filter_var($quantity, FILTER_VALIDATE_INT)){
            array_push($violations,"Podana ilość nie jest prawidłową liczba.<br>");
        }
        if($quantity<0){
            array_push($violations,"Ilość produktu nie może być ujemna<br>");
        }
        if($quantity>1000000){
            array_push($violations,"Ilość produktu musi być mniejsza niż 1 000 000<br>");
        }
    }

    private function validateSize($size, &$violations){
        if(count(ProductSizeEnum::GetConstants())-1<$size){
            array_push($violations,"Podany rozmiar jest nieprawidłowy<br>");
        }
    }

    private function validateColour($colour, &$violations){
        if(count(ProductColourEnum::GetConstants())-1<$colour){
            array_push($violations,"Podany kolor jest nieprawidłowy<br>");
        }
    }



}