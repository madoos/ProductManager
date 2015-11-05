<?php
/**
 * Created by PhpStorm.
 * User: maurice
 * Date: 19/10/2015
 * Time: 10:07
 */
require('../config.php');
require('../classes/ProductManager.php');
require('../models/ProductModel.php');
$productsLinks = new SearchProducts();

class SearchProducts {

    public $products;

    public function __construct(){
        //parent::construct; arreglar herencia!
        $this->products = [];
        $this->{$_SESSION['action']}();
    }

    public function index(){
        //$this->renderView('/searchProductsLinks/configureProducstLinks');
        $productsLinks = ProductModel::getProductsData('allLinksProducts');
        $this->createProducts($productsLinks);
    }

    public function addProduct($product){
        array_push($this->products,$product);
    }

    private function renderView($view,$data=null){
        $__baseLayout  =  '__baseLayout';
        $_SESSION['__pathView'] = $view;
        if( !is_null($data) )$_SESSION['data'] = $data;
        header("Location: ../views/$__baseLayout.php");
    }

    private function createProducts($productsLinks){
        extract($_POST, EXTR_SKIP);
        foreach($productsLinks as $productLink){
            set_time_limit(0);
            $product = new ProductManager($productLink,$prefix);
            $product->addValue($queryName,'name');
            $product->addValue($queryPrice,'price');
            $product->addValue($queryDescription,'description');
            $product->addValue($querySpecifications,'specifications');
            $product->addValue($queryImages,'images',$imgUrlBase);
            $product = get_object_vars($product);
            unset($product['xpath']);
            $this->addProduct($product);
        }
        $_SESSION['products'] = $this->products;
        $this->renderView('/searchProducts/preVisualizationProduct');
    }

    public function saveProducts(){
        $products = $_SESSION['products'];
        ProductModel::saveData($products,"products");
        unset( $_SESSION['products'] );
        $this->renderView("/processFile/configFiles");
    }
}