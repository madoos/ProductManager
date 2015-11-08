<?php
/**
 * Created by PhpStorm.
 * User: maurice
 * Date: 20/10/2015
 * Time: 11:35
 */
require('../config.php');
require('../models/ProductModel.php');
require('../helpers/HelperFileFormatting.php');
$prosessFile = new ProsessFile();

class ProsessFile {

    public function __construct(){
        //parent::construct; arreglar herencia!
        $this->{$_SESSION['action']}();
        set_time_limit(0);
    }

    public function handleGetFlies(){
        set_time_limit(0);
        extract($_POST,EXTR_SKIP);
        $products =  HelperFileFormatting::objectsToArray( ProductModel::getProductsData('products') );
        switch ( $programOptions ) {
            case 1:
                $zipClient = FILES_PATH.'files.zip';
                $productCsv = CSV_PATH.'gesioProducts.csv';
                $imgesCsv = CSV_PATH.'gesioAllImgProducts.csv';
                $this->createCsvProducts($productCsv,$products,$csvDelimiter);
                $this->createCsvImages($products,$imgesCsv,',');
                $this->downloadsImages($products,IMAGES_PATH);
                $this->generateBatches($imgesCsv,$numItems,BATCHES_PATH);
                HelperFileFormatting::zipEntireFolder(FILES_PATH,$zipClient);
                HelperFileFormatting::sendClientFile($zipClient,'zip');
                HelperFileFormatting::deleteFillesFromDirectoryTree(FILES_PATH);
                break;
            case 2:
                //for other things we do not know!
                break;
        }
    }

    private function downloadsImages($products,$pathImages){
        foreach($products as $product){
            for($i=0; $i<count($product['images']);$i++){
                $imgName = $pathImages.$i.$product['id'].'.jpg';
                $url = $product['images'][$i];
                HelperFileFormatting::downloadFile($url,$imgName);
            }
        }
    }

    private function createCsvProducts($name,$products,$delimiter){
        $columDefinition = array('id','name','price','description','specifications');
        $csvProdcuts = array($columDefinition);
        foreach($products as $product){
            unset($product['images']);
            $csvProdcuts[] = $product;
        }
        HelperFileFormatting::createCsv($csvProdcuts,$name,$delimiter);
    }

    private function createCsvImages($products,$pathCsv,$delimiter){
        $csvImages = [];
        foreach($products as $product){
            $productId = $product['id'];
           for($i = 0; $i<count($product['images']) ;$i++){
               $nameImg = $i.$product['id'].'.jpg';
               $csvImages[] = array($productId,$nameImg);
           }
        }
        HelperFileFormatting::createCsv($csvImages,$pathCsv,$delimiter);
    }

    private function generateBatches($csvImages,$itemForBatch){
        $source = HelperFileFormatting::csvToArray($csvImages);
        $batches =  array_chunk($source,$itemForBatch) ;
        $columDefinition = array('idProduct','pathImg');
        $batches = HelperFileFormatting::unshiftColumDefinition($batches,$columDefinition);
        foreach( $batches as $key => $batch){
            $batchName = BATCHES_PATH.'batch'.$key.'.csv';
            $zipName = BATCHES_PATH.'batch'.$key.'.zip';
            HelperFileFormatting::createCsv($batch,$batchName,',');
            HelperFileFormatting::createZip( $zipName , $this->getImagesFromBatch($batch), IMAGES_PATH);
        }
}

    private function getImagesFromBatch($batch){
        return array_map(function($productImage){
                return $productImage[1];
        },$batch);
    }

    private function renderView($view,$data=null){
        $__baseLayout  =  '__baseLayout';
        $_SESSION['__pathView'] = $view;
        if( !is_null($data) )$_SESSION['data'] = $data;
        header("Location: ../views/$__baseLayout.php");
    }


}