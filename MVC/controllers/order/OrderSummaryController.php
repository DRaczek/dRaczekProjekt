<?php
include_once("MVC/models/databaseModels/ProductModel.php");
include_once("MVC/models/databaseModels/DeliveryModel.php");
include_once("MVC/models/databaseModels/PaymentMethodsModel.php");
include_once("MVC/models/validationHelpers/OrderValidationHelper.php");
include_once("MVC/controllers/order/OrderController.php");
include_once("MVC/models/databaseModels/CategoryModel.php");    

class OrderSummaryController extends OrderController{
    public function __construct(){

    }

    public function displayOrderSummaryPage(){
        $this->RedirectIfNotLoggedIn();
        if(!$this->isCartApproved()){
            $_SESSION['message'] = "Wystąpił błąd związany z zwartością koszyka.";
            header("Location:/dRaczekProjekt/cart");
            exit();
        }
        //walidacja formularza
        try{
            $validationHelper = new OrderValidationHelper();
            $validationHelper->validate();
        }
        catch(Exception $e){    
            $_SESSION['message'] = $e->getMessage();
            http_response_code(400);
            header("Location:../order/data");
            exit();
        }

        //wysweitla podsumowanie zamowienia
        $koszyk = null;
        if(isset($_COOKIE['cart'])){
            $koszyk=unserialize($_COOKIE['cart']);
        }
        $productModel = new ProductModel();
        $summary = 0;
        foreach($koszyk as &$product){
            $data = $productModel->getProductCartData($product['productId']);
            $product['name'] = $data['name'];
            $product['image_path'] = $data['image_path_1'];
            $product['price'] = $data['price'];
            $product['product_quantity'] = $data['quantity'];
            $summary+=$product['price']* $product['quantity'];
        }
        unset($product);
        // uniewaznienie referencji

        $paymentMethodsModel = new PaymentMethodsModel();
        $paymentMethodName = $paymentMethodsModel->getPaymentMethodName($_POST['payment_method_id']);
        $deliveryModel = new DeliveryModel();
        $delivery = $deliveryModel->getPriceAndName($_POST['delivery_id']);

        $data = array();
        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $data['cart'] = $koszyk;
        $data['summary'] = $summary;
        $data['delivery'] = $delivery;
        $data['paymentMethodName'] = $paymentMethodName;
        $data['categories'] = $headerData['categories'];
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/order/OrderSummaryPage", $data, false);
    }
}