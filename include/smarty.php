<?php

ini_set("display_errors","On"); error_reporting(E_ALL &~ E_NOTICE);
// load Smarty library
require_once('../smarty/Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = '../smarty/2645-6/templates/';
$smarty->compile_dir = '../smarty/2645-6/templates_c/';
$smarty->config_dir = '../smarty/2645-6/configs/';
$smarty->cache_dir = '../smarty/2645-6/cache/';
$smarty->left_delimiter='{#';
$smarty->right_delimiter='#}';

$smarty->compile_check = true;
$smarty->caching = false;

?>