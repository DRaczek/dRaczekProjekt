<?php
include_once("MVC/models/databaseModels/DeliveryModel.php");
include_once("MVC/models/databaseModels/PaymentMethodsModel.php");

class OrderValidationHelper{
    public function __construct(){

    }

    public function validate($edit=false){
        $violations = array();
        $targetFiles = null;
        if(!isset($_POST['submit'])
        || !isset($_POST['first_name'])
        || !isset($_POST['last_name'])
        || !isset($_POST['street'])
        || !isset($_POST['street_number'])
        || !isset($_POST['postal_code'])
        || !isset($_POST['postal_city'])
        || !isset($_POST['country'])
        || !isset($_POST['nip'])
        || !isset($_POST['company_name'])
        || !isset($_POST['delivery_id'])
        || !isset($_POST['payment_method_id'])
        ){
            array_push($violations, "Nie wszystkie pola zostały przesłane<br>");
        }
        else{
            if($edit===true){
                if(!isset($_POST['delivery_tracking']) 
                || !isset($_POST['payment_status']) 
                || !isset($_POST['order_status'])){
                    array_push($violations, "Nie wszystkie pola zostały przesłane<br>");
                }
            }

            if(!isset($_POST['is_company']))$_POST['is_company']="off";
            $this->validateCompany($_POST['is_company'], $_POST['nip'], $_POST['company_name'], $violations);
            $this->validateName($_POST['first_name'], $_POST['last_name'], $violations);
            $this->validateAddress($_POST['street'], $_POST['street_number'], $_POST['postal_code'], $_POST['postal_city'], $_POST['country'], $violations);
            if($edit===true){
                $this->validateEditFields($_POST['delivery_tracking'], $_POST['payment_status'], $_POST['order_status'], $violations);
            }
        }
        if(count($violations)>0){
            throw new Exception(implode(" ", $violations));
            return null;
        }
    }

    private function validateEditFields($delivery_tracking, $paymentStatus, $orderStatus, &$violations){
        if (!preg_match('/[\p{N}\P{L}!@#$%^&*()\-_=+|;:\'",.?\w]{2,250}/u', $delivery_tracking)) {
            array_push($violations, "Podany link do śledzenia dostawy jest niepoprawny<br>");
        }
        if($paymentStatus<0 || $paymentStatus >= count(PaymentStatusEnum::GetConstants())){
            array_push($violations, "Podany status płatności jest niepoprawny<br>");
        }
        if($orderStatus<0 || $orderStatus >= count(OrderStatusenum::GetConstants())){
            array_push($violations, "Podany status zamówienia jest niepoprawny<br>");
        }
    }

    private function validateDelivery($id, &$violations){
        $deliveryModel = new DeliveryModel();
        if(!$deliveryModel->deliveryMethodExistsAndIsAvailable($id)){
            array_push($violations, "Podana metoda dostawy nie istnieje lub nie jest dostepna<br>");
        }
    }

    private function validatePayment($id, &$violations){
        $paymentMethodModel = new PaymentMethodModel();
        if(!$paymentMethodModel->paymentMethodExistsAndIsAvailable($id)){
            array_push($violations, "Podana metoda płatności nie istnieje lub nie jest dostepna<br>");
        }
    }

    private function validateAddress($street, $streetNumber, $postalCode, $postalCity, $country, &$violations){
        //litery polskiego alfabetu, ., -, spacja
        if (!preg_match('/[A-Za-ząćęłńóśźżĄĆĘŁŃÓŚŹŻ.\-\s]{2,250}/u', $street)) {
            array_push($violations, "Podana nazwa ulicy jest niepoprawna.<br>");
        }
        // liczby + litery, np. 7a
        if (!preg_match('/^\d+[A-Za-z]*$/', $streetNumber)) {
            array_push($violations, "Podany numer domu jest niepoprawny.<br>");
        }
        if(strlen($streetNumber)>10){
            array_push($violations, "Podany numer domu jest niepoprawny.<br>");
        }
        //format xx-xxx
        if (!preg_match('/^\d{2}\-\d{3}$/', $postalCode)) {
            array_push($violations, "Podany kod pocztowy jest niepoprawny.<br>");
        }
        // sprawdzenie, czy nazwa miejscowości jest poprawna
        if (!preg_match('/[A-Za-ząćęłńóśźżĄĆĘŁŃÓŚŹŻ.\-\s]{2,250}/u', $postalCity)) {
            array_push($violations, "Podana miejscowość jest niepoprawna.<br>");
        }
        // sprawdzenie, czy kraj jest poprawny
        if (!preg_match('/^[A-Za-z]{2}$/', $country)) {
            array_push($violations, "Podany kraj jest niepoprawny.<br>");
        }
    }

    private function validateName($firstName, $lastName, &$violations){
        if (!preg_match('/[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]{2,100}/u', $firstName)) {
            array_push($violations, "Podane imię jest niepoprawne.<br>");
        }
        if (!preg_match('/[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]{2,100}/u', $lastName)) {
            array_push($violations, "Podane nazwisko jest niepoprawne.<br>");
        }
    }

    private function validateCompany($isCompany, $nip, $name, &$violations){
        $acceptableCheckBoxValues = ["on", "off"];
        if(!in_array($isCompany, $acceptableCheckBoxValues)){
            array_push($violations, "Przesłane dane są niepoprawne.<br>");
            return;
        }
        if($isCompany==="on"){
            $this->validateNip($nip, $violations);
            $this->validateCompanyName($name, $violations);
        }
    }

    private function validateNip($nip, &$violations){
        if (!preg_match('/^[0-9]{10}$/', $nip)) {
            array_push($violations, "Podany nip jest niepoprawny.<br>");
            return;
        }
        else{
            $weights = [6, 5, 7, 2, 3, 4, 5, 6, 7];
            $sum = 0;
            for ($i = 0; $i < 9; $i++) {
                $sum += $nip[$i] * $weights[$i];
            }
            $checksum = $sum % 11;
            if ($checksum == 10) {
                $checksum = 0;
            }
            
            if ($checksum != $nip[9]) {
                array_push($violations, "Podany nip jest niepoprawny.<br>");
            }
        }
    }

    private function validateCompanyName($name, &$violations){
        if (!preg_match('/^([A-Za-ząćęłńóśźżĄĆĘŁŃÓŚŹŻ0-9,.\-\s]){2,250}$/', $name)) {
            array_push($violations, "Nazwa firmy jest niepoprawna.<br>");;
        }
    }

}