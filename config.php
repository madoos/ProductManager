<?php
session_start();
define('JS_PATH', dirname(__FILE__) . '/assets/js/');
define('CSS_PATH', dirname(__FILE__) . '/assets/css/');
define('CONTROLLERS_PATH', dirname(__FILE__) . '/controllers/');
define('MODELS_PATH', dirname(__FILE__) . '/models/');
define('VIEWS_PATH', dirname(__FILE__) . '/views/');
define('CLASSES_PATH', dirname(__FILE__) . '/classes/');
define('FILES_PATH', dirname(__FILE__) . '/files/');
define('IMAGES_PATH', FILES_PATH . 'images/');
define('CSV_PATH', FILES_PATH . 'csv/');
define('BATCHES_PATH', FILES_PATH . 'batches/');
define('UPLOADS_PATH', FILES_PATH . 'uploads/');
define('DATA_PATH', MODELS_PATH.'data/');
//USER CONFIG
define('DEFAUL_CONTROLLER', 'searchProductsLinks');

