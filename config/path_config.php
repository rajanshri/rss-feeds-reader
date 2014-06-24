<?php
    
	$root_path = 'http://domain.com/'; //enter your site domain path
    define('ABSOLUTE_PATH', dirname(dirname(__FILE__)));
    defined('ROOT_PATH') || define('ROOT_PATH', $root_path);
    defined('CSS_PATH') || define('CSS_PATH', ROOT_PATH . 'css/');
    defined('JS_PATH') || define('JS_PATH', ROOT_PATH . 'js/');
    defined('IMAGES_PATH') || define('IMAGES_PATH', ROOT_PATH . 'images/');
    defined('INCLUDE_PATH') || define('INCLUDE_PATH', ROOT_PATH . 'include/'); 
	
	define('SITE_NAME', 'RSS Reader');
	
?>
