<?php
session_start();

require_once '../php/template.php';
include( "../php/Control.php");


$control = new Control();
// Initialize object
$tpl = new template('main.tpl', false);

$tpl->set('head', $tpl->getFile('head.tpl', false));
$tpl->set('menu', $tpl->getFile('menu.tpl', false));

$tpl->set('footer', $tpl->getFile('footer.tpl', false));

if(isset($_POST['submitSignIn'])){
	$signdin = $control->getAuth();
	if($signdin){
		$_SESSION["signedin"]	= "yes";
	}
}

if(isset($_SESSION["signedin"]) && ($_SESSION["signedin"] == "yes") ){
	$tpl->set('Content', $tpl->getFile('Content-AddProduct.tpl', false));
	$tpl->set('signout', "<a href='{root}/pages/signout.php'>Sign Out</a>");
	$tpl->set('mycart', "<a href='{root}/pages/orders.php'>Orders</a>");
}else{
	$tpl->set('Content', $tpl->getFile('Content-SignIN.tpl', false));
	$tpl->set('signout', "");
	$tpl->set('mycart', "<a href='{root}/pages/cart.php'>Cart</a>");
}
if(isset($_POST['submitAddProduct'])){
	$added = $control->addProduct();
	if($added){
		$tpl->set('success', "<p>Successfully Added</p>");
	}else{
		$tpl->set('success', "<p>Error in saving</p>");
	}
}else{
	$tpl->set('success', "");

}
$tpl->set('banner', '');
$tpl->set('root', '..');

// Render the template
$tpl->render();