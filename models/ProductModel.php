<?php

class ProductModel {

    public static function saveData($data,$nameFile){
        file_put_contents( DATA_PATH.$nameFile.".json", json_encode($data) );
    }

    public static function getProductsData($nameFile){
        return json_decode( file_get_contents( DATA_PATH.$nameFile.".json" ) );
    }
}