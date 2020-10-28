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
$tpl->set('signout', "");
$tpl->set('mycart', "<a href='{root}/pages/cart.php'>Cart</a>");

unset($_SESSION["signedin"]);
$tpl->set('Content', $tpl->getFile('Content-SignOUT.tpl', false));

$tpl->set('banner', '');
$tpl->set('root', '..');

// Render the template
$tpl->render();