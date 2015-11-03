<?php
/**
 * Created by PhpStorm.
 * User: maurice
 * Date: 17/10/2015
 * Time: 2:15
 */

class ControllerCore {
//Este tendria que ser el controlador por defecto para que llamae a una vista por defecto
//Aqui tenemos que arreglar lo de la herencia


   public function index(){
      $this->renderView('__defaulView');
   }

   public function renderView($view,$data=false){
      if( !is_null($data) )$_SESSION[$view] = $data;
      header("Location: ../views/$view.php");
   }


}