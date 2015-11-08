<?php
/**
 * Created by PhpStorm.
 * User: maurice
 * Date: 17/10/2015
 * Time: 2:29
 */
require('../config.php');
require('../classes/ProductManager.php');
require('../models/ProductModel.php');
$productsLinks = new SearchProductsLinks();

class SearchProductsLinks {

    public function __construct(){
        //parent::construct; arreglar herencia!
        $this->{$_SESSION['action']}();
        set_time_limit(0);
    }

    public function index(){
        $this->renderView('/searchProductsLinks/configureProductsLinks');
    }

    public function handleGetLinks(){
        extract($_POST, EXTR_SKIP);
        switch ( $_POST['programOptions'] ) {
            case 1:
                $productsLinks =  explode( "," , trim($textProductLinks) );
                $productsLinks =  ProductManager::setUrlBase($urlBase,$productsLinks);
                $productsLinks = array_unique($productsLinks);
                break;
            case 2:
                $productsLinks = $this->getProductsFromLastCategory($urlBase,$urlPage,$className);
                break;
            case 3:
                $categories =  explode( "," , str_replace('"', '', trim($textProductLinks))  );
                $productsLinks = $this->getProductsFromCategories($urlBase,$categories,$className);
                break;
            case 4:
                $productsLinks = $this->getLinks();
                break;
            case 5:
                $productsLinks = $this->getProductsFromCategoryPaginates($nunPages,$nameVarPages,$urlBase,$urlPage,$className);
                break;
            default:
                echo "tienes que crear una vista de error";
        }
        $this->renderView('/searchProductsLinks/productsLinksResults',$productsLinks);
    }

    public function getProductsFromCategoryPaginates($numPages,$nameVarPages,$urlBase,$url,$className){
        $products = [];
        for( $i = 1; $i<=(int)$numPages; $i++ ){
           $urlPaginate = $url ."?". $nameVarPages ."=". $i."<br>";
           $productsLinks = $this->getProductsFromLastCategory($urlBase,$urlPaginate,$className);
           $products = array_merge($productsLinks,$products);
        }
        return $products;
    }

    public function getProductsFromCategories($urlBase,$categories,$className){
        $allProducts = [];
        foreach( $categories as $urlCategory){
            $productsLinks = $this->getProductsFromLastCategory($urlBase,$urlCategory,$className);
            $allProducts = array_merge($productsLinks, $allProducts);
        }
        return $allProducts;

    }

    public function getProductsFromLastCategory($urlBase,$url,$className){
        set_time_limit(0);
        $produtsLinks = ProductManager::getAhreftLinks( $url,$className);
        $produtsLinks = ProductManager::setUrlBase( $urlBase,$produtsLinks);
        $produtsLinks = array_unique($produtsLinks);
        return $produtsLinks;
    }

    public function getLinks($xpathQuery){
       //Esto es guarra arrreglarlo --> menos de 6 lneas fijo!
        set_time_limit(0);
        $urlbase = $_POST['urlBase'];
        $url = $_POST['urlPage'];
        $className = $_POST['className'];

        $elements = ProductManager::getAhreftLinks( $url,$xpathQuery);
        $categories  = ProductManager::setUrlBase($urlbase,$elements);
        $subCategories = [];
        foreach ($categories  as $categorie) {
            set_time_limit(0);
            $subcats =  ProductManager::setUrlBase( $urlbase, ProductManager::getAhreftLinks( $categorie,$xpathQuery ) );
            $subCategories = array_merge($subCategories,$subcats);
        }
        $produtsLinks = [];
        foreach ( $subCategories as $subcatLink) {
            set_time_limit(0);
            $productsFromSubCat =  ProductManager::getAhreftLinks( $subcatLink,$xpathQuery ) ;
            $produtsLinks  = array_merge($produtsLinks,$productsFromSubCat);
        }

        $produtsLinks = ProductManager::setUrlBase( $urlbase,$produtsLinks);
        $produtsLinks = array_unique($produtsLinks);

       return $produtsLinks;

    }

    public function configProductSearch(){
        $this->renderView('configProductSearch');
    }

    private function renderView($view,$data=null){
        $__baseLayout  =  '__baseLayout';
        $_SESSION['__pathView'] = $view;
        if( !is_null($data) )$_SESSION['data'] = $data;
        header("Location: ../views/$__baseLayout.php");
    }

    public function saveProductsLinks(){
        ProductModel::saveData( $_SESSION['data'], "allLinksProducts" );
        unset( $_SESSION['data'] );
        $this->renderView('/searchProducts/configureProductSearch');
    }


}