<?php
/**
 * Created by PhpStorm.
 * User: Madoos
 * Date: 26/10/2015
 * Time: 11:30
 */

require('../config.php');
require('../models/ProductModel.php');
require('../helpers/HelperFileFormatting.php');

if( isset($_GET['action'])){
    $_SESSION['action'] = 'auxUpload';
}

$productCombination = new ProductCombination();

class ProductCombination {

    public function __construct(){
        $this->{$_SESSION['action']}();
    }


    public function uploadFile(){
       $data =  HelperFileFormatting::uploadFilesToServer(UPLOADS_PATH,'filesCsv');
        $this->renderView('/productCombination/configCombination',$data);
    }


    public function generateCombinations(){
        $allSimpleProducts = $this->getSimpleProductInfo(UPLOADS_PATH);
        $sizes = $_POST['sizes'];
        $productsCombinations = [];
        foreach($allSimpleProducts as $simpleProduct){
            $productCombination = $this->setCombination($simpleProduct,$sizes);
            $productsCombinations = array_merge($productsCombinations,$productCombination);
        }
        $columDefinition = array('IDPADRE','IDPRODUCTO','TALLA','NTALLA');
        array_unshift($productsCombinations,$columDefinition);
        var_dump($productsCombinations);
        HelperFileFormatting::createCsv($productsCombinations,CSV_PATH.'gesioProductsCombination.csv');
    }

    private function setCombination($product,$sizes){
        $productCombination = [ array($product[0],$product[0],'por defecto','TALLAS') ];
        foreach($sizes as $size){
            $idParent =  $product[0];
            $idCombination = $product[0].$size;
            $productCombination[] = array($idParent,$idCombination,$size,'TALLAS');
        }
        return $productCombination;
    }

    private function renderView($view,$data=null){
        $__baseLayout  =  '__baseLayout';
        $_SESSION['__pathView'] = $view;
        if( !is_null($data) )$_SESSION['data'] = $data;
        header("Location: ../views/$__baseLayout.php");
    }

    /////////////////aux function ///////////////
    public function auxUpload(){
        $this->renderView('/productCombination/uploadFiles');
    }

    private function getSimpleProductInfo($csvsPaths){
        $allProducts = [];
        $files = glob($csvsPaths.'*.csv');
        foreach($files as $file){
            $productsBache = HelperFileFormatting::csvToArray($file,'|');
            foreach($productsBache as $product){
                $id = $product[0];
                $name =  $product[1];
                if($product[0] != 'id'){
                    $rowCsv = array( $id , $name );
                    $allProducts[] =  $rowCsv;
                }

            }
        }

        return $allProducts;
    }
}