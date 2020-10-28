<?php

include("Database.php");
include("View.php");


Class Control{
	public $database ;
	public $view;
	
	public function __construct(){
		$this->database = new Database('localhost' , 'furniture' , 'root', '');
   		$this->database->connectdb();
		$this->view = new View();
    }
	public function getReviews(){
		$liked = $this->database->DBGetLiked();
		$ratnng = $this->database->DBGetRating();
		$arr_data = array();
		$arr_data = $this->database->DBGetReviews();
		return $this->view->VviewReviews($liked,$ratnng, $arr_data);
	}
	
	public function addReview(){
		$liked = 0;
		if(isset($_POST['liked'])){
			$liked = 1;
		}
		$rate = 3;
		if(isset($_POST['rate'])){
			$rate= $_POST['rate'];
		}
		$this->database->DBAddReview($liked ,$rate);
	}
	public function getAuth(){
		$Auth = $this->database->DBGetAuth();
		return $Auth;
	}
	public function addProduct(){
		$added = $this->database->DBAddProduct();
		return $added;
	}
	public function getProduct($ProductId){
		$arr_data = array();
		$arr_data = $this->database->DBGetProduct($ProductId);
		return $this->view->VviewProduct($arr_data);
	}
	public function search(){
		$arr_data = array();
		$arr_data = $this->database->DBGetSearch($_POST['term']);
		return $this->view->VviewSearch($arr_data);
	}
	public function browse(){
		$arr_data = array();
		$arr_data = $this->database->DBGetBrowse();
		return $this->view->VviewBrowse($arr_data);
	}
	public function addToCart($productId){
		$product = $this->database->DBGetProduct($productId);
		//print_r($product);
		if(!isset($_SESSION['cart'][$productId])){
			$_SESSION['cart'][$productId]['amount'] = 1;
			$_SESSION['cart'][$productId]['preis'] = $product['preis'];
			$_SESSION['cart'][$productId]['title'] = $product['title'];
			$_SESSION['cart'][$productId]['color'] = $product['color'];
			$_SESSION['cart'][$productId]['type'] = $product['type'];
			$_SESSION['cart'][$productId]['img1'] = $product['img1'];
		}else{
			$_SESSION['cart'][$productId]['amount']++;
		}
	}
	public function deleteAllCart(){
		unset($_SESSION['cart']);
	}
	public function deleteFromCart($emptyId){
		unset($_SESSION['cart'][$emptyId]);
		if (empty($_SESSION['cart'])) {
			unset($_SESSION['cart']);
		}
	}
	public function viewCart(){
		return $this->view->VviewCart();
	}
	public function saveCustomerCart(){
		$added = $this->database->DBAddCustomerCart();
		return $added;
	}
	public function viewOrders(){
		$arr_data = array();
		$arr_data = $this->database->DBGetOrders();
		$arr_data2 = array();
		$arr_data2 = $this->database->DBCompleteGetOrders($arr_data);
		return $this->view->VviewOrders($arr_data2);
	}
}
?>