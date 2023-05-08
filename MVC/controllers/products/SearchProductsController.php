<?php
include("MVC/controllers/Controller.php");
include_once("MVC/models/databaseModels/CategoryModel.php");
include_once("MVC/models/databaseModels/ProductModel.php");

class SearchProductsController extends Controller{
    public function __construct(){

    }
    
    public function search($pageable = "page=1&size=20"){

        $pageable = explode("&", $pageable);
        $pageable=array_slice($pageable,2);
        $pageable="&".implode("&",$pageable);

        if(!isset($_GET['page'])){
            $_GET['page']=1;
        }
        if(!isset($_GET['size'])){
            $_GET['size']=10;
        }
        $page = intval($_GET['page']);
        if($page<1)$page=1;
        $pageSize = intval($_GET['size']);
        $name= null;
        $categoryId=null;
        $gender=null;
        $size=null;
        $colour=null;
        $price_from=null;
        $price_to=null;
        $orderBy = null;
        $order = null;
     
        if(isset($_GET['text'])){
            $name = $_GET['text'];
        }
        if(isset($_GET['gender'])){
            $gender = intval($_GET['gender']);
        }
        if(isset($_GET['colour'])){
            $colour = intval($_GET['colour']);
        }
        if(isset($_GET['categoryId'])){
            $categoryId = intval($_GET['categoryId']);
        }
        if(isset($_GET['productSize'])){
            $size = intval($_GET['productSize']);
        }
        if(isset($_GET['price_from'])){
            $price_from = floatval($_GET['price_from']);
        }
        if(isset($_GET['price_to'])){
            $price_to = floatval($_GET['price_to']);
        }
        if(isset($_GET['orderBy'])){
            $orderBy = $_GET['orderBy'];
        }
        if(isset($_GET['order'])){
            $order = $_GET['order'];
        }

        $firstResult = ($page - 1) * $pageSize;

        if($gender===999)$gender=null;
        if($size===999)$size=null;
        if($categoryId===999)$categoryId=null;
        if($colour===999)$colour=null;

        try{
            $productModel = new ProductModel();
            $products = $productModel->searchProducts(  $firstResult,
                                                        $pageSize,
                                                        $name,
                                                        $categoryId,
                                                        $gender,
                                                        $price_from,
                                                        $price_to,
                                                        $size,
                                                        $colour,
                                                        $orderBy,
                                                        $order
            );

            $count = $productModel->searchProductsCount($name,
                                                        $categoryId,
                                                        $gender,
                                                        $price_from,
                                                        $price_to,
                                                        $size,
                                                        $colour
            );
        }
        catch(Exception $e){
            die("Fatal Error!");
        }

        $acceptableOrderByArray = array(
            "created_date" => "Data dodania",
            "view_count" => "Ilość wyświetleń"
        );
        $data = array();
        $categoryModel = new CategoryModel();
        $headerData = array(
            "categories"=>$categoryModel->getCategories()
        );
        $data['pageable'] = $pageable;
        $data['page']=$page;
        $data['pageSize']=$pageSize;
        $data['products_count']=$count;
        $data['products'] = $products;
        $data['orderByTable'] = $acceptableOrderByArray;
        $data['categories'] = $headerData['categories'];
        $data['header']=$this->loadView("MVC/views/common/header", $headerData, true);
        $data['footer']=$this->loadView("MVC/views/common/footer", null, true);
        $data['styles']='<link rel="stylesheet" href="/dRaczekProjekt/css/header.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/footer.css">
        <link rel="stylesheet" href="/dRaczekProjekt/css/basicLayout.css">';
        $this->loadView("MVC/views/product/searchProductsView", $data, false);
    }
}