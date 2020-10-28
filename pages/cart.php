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
$tpl->set('Content', $tpl->getFile('Content-Cart.tpl', false));
if(isset($_GET['productId'])){
	$control->addToCart($_GET['productId']);
}

if(isset($_GET['reserve']) && $_GET['reserve'] == "yes" && isset($_POST['submitReserveCart'])){
	if(isset($_SESSION['cart'])){
		$added = $control->saveCustomerCart();
		if($added === true){
			$tpl->set('success', "Successfully added" );
		}else{
			$tpl->set('success', "Problem cart cannot be saved" );
		}
	}else{
		$tpl->set('success', "Please fill the cart first" );
	}
}else{
	$tpl->set('success', "" );
}



if(isset($_GET['empty']) && $_GET['empty'] = "all"){
	$control->deleteAllCart();
}
if(isset($_GET['emptyId'])){
	$control->deleteFromCart($_GET['emptyId']);
}

$cart = $control->viewCart();
$tpl->set('cart', $cart );

// Render the template
$tpl->render();