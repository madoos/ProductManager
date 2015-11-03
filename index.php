<?php
/**
 * Created by PhpStorm.
 * User: maurice
 * Date: 17/10/2015
 * Time: 1:55
 */
require_once('./config.php');
$_SESSION['action'] = 'index';
$controller = DEFAUL_CONTROLLER;
header("Location: ./controllers/$controller.php");
