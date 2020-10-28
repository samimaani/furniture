<?php
session_start();

require_once '../php/template.php';
include( "../php/Control.php");


if(isset($_POST['submit'])){
	/*
	ini_set("SMTP", "aspmx.l.google.com");
	ini_set("sendmail_from", "samsooom@gmail.com");
	
	$message = "The mail message was sent with the following mail setting:\r\nSMTP = aspmx.l.google.com\r\nsmtp_port = 25\r\nsendmail_from = YourMail@address.com";
	
	$headers = "From: samsooom@gmail.com";
	
	mail("samsooom@gmail.com", "Testing", $message, $headers);
	echo "Check your email now....&lt;BR/>";
	*/
	$email= "samsooom@gmail.com";
	$msg = $_POST["message"];
	$name = $_POST["name"];
	$subject = "Test Email " ;
	$to= $_POST["email"];
	ini_set("SMTP", "aspmx.l.google.com");
	ini_set("sendmail_from", "samsooom@gmail.com"); 
	ini_set( 'smtp_port', 25 );
	$headers = "From: $name < $email >."; 
	$headers .= "\r\nContent-Type: text/html; charset=ISO-8859-1\r\n";
	mail($to, $subject, $msg, $headers) ;

}

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

$tpl->set('Content', $tpl->getFile('Content-ContactUs.tpl', false));

// Render the template
$tpl->render();