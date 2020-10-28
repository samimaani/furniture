<?php
session_start();

require_once '../php/template.php';
include( "../php/Control.php");




$control = new Control();
// Initialize object
$tpl = new template('main.tpl', false);

$tpl->set('head', $tpl->getFile('head.tpl', false));
$tpl->set('menu', $tpl->getFile('menu.tpl', false));
if(isset($_SESSION["signedin"]) && ($_SESSION["signedin"] == "yes") ){
	$tpl->set('signout', "<a href='{root}/pages/signout.php'>Sign Out</a>");
	$tpl->set('mycart', "<a href='{root}/pages/orders.php'>Orders</a>");
}else{
	$tpl->set('signout', "");
	$tpl->set('mycart', "<a href='{root}/pages/cart.php'>Cart</a>");
}

$tpl->set('footer', $tpl->getFile('footer.tpl', false));
$tpl->set('root', '..');

$tpl->set('banner', '');

$tpl->set('Content', $tpl->getFile('Content-Search.tpl', false));
if(isset($_POST['submitSearch'])){
	$result = $control->search();
	$tpl->set('result', $result);
}else{
	$tpl->set('result', "");
}

// Render the template
$tpl->render();