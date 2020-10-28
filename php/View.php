<?php

Class View {
	public function __construct(){
    }

	public function VviewReviews($liked,$ratnng, $arr_data){
		$returnedValue ="";
		$returnedValue .="<h3>Total Liked: ".$liked['total']."</h3>";
		$returnedValue .="<h3>Average Rating: ".round($ratnng['average'],2)."</h3>";
		foreach($arr_data as $m)
		{
				$returnedValue .= "<fieldset>";
					$returnedValue .= $m['messege'];
				$returnedValue .= "</fieldset>";
				$liked = "<img id='liked' src='../css/images/like.jpg'>";
				if($m['liked'] == 0){
					$liked = "<img id='disliked' src='../css/images/dislike.jpg'>";
				}
				$returnedValue .= "<p class='post-footer align-left'>
						<a class='comments' >".$m['name']."</a>
						<span class='date'>".$m['date']."</span>
						<span class='rate'>Rating: ".$m['rate']."</span>
						".$liked."
						</p>";
				$returnedValue .= "<div style='clear:both; margin-bottom:20px;'></div>";
		}
		return $returnedValue;
	}
	
	public function VviewProduct($arr_data){
		$returnedValue ="";
		$addCart = "<a style='float:right;' href='cart.php?productId=".$arr_data['id']."'><strong>+ Add to Cart</strong></a>";
		if(isset($_SESSION["signedin"]) && ($_SESSION["signedin"] == "yes") ){
			$addCart = "";
		}

		$returnedValue .="<h3>Product id: ".$arr_data['id']." ".$addCart."</h3>";
		$returnedValue .="<p><strong>Price:</strong> ".round($arr_data['preis'],2)." SYP<br />";
		$returnedValue .="<strong>Title:</strong> ".$arr_data['title']."<br />";
		$returnedValue .="<strong>Color:</strong> ".$arr_data['color']."<br />";
		$returnedValue .="<strong>Type:</strong> ".$arr_data['type']."</p> ";
		$returnedValue .="<img class='col-xs-6 col-sm-3' src='data:image/png;base64,".base64_encode($arr_data['img1'])."'>";
		if($arr_data['img2'] != ""){
			$returnedValue .="<img class='col-xs-6 col-sm-3' src='data:image/png;base64,".base64_encode($arr_data['img2'])."'>";
		}
		if($arr_data['img3'] != ""){
			$returnedValue .="<img class='col-xs-6 col-sm-3' src='data:image/png;base64,".base64_encode($arr_data['img3'])."'>";
		}
		if($arr_data['img4'] != ""){
			$returnedValue .="<img class='col-xs-6 col-sm-3' src='data:image/png;base64,".base64_encode($arr_data['img4'])."'>";
		}
		$returnedValue .= "<div style='clear:both; margin-bottom:20px;'></div>";
		$returnedValue .="<p><strong>Description:</strong> ".$arr_data['description']."</p>";

		return $returnedValue;
	}
	
	public function VviewSearch($arr_data){
		//echo md5('123');
		$returnedValue ="";
		if(empty($arr_data)){
			$returnedValue .="<p><strong>There were no results found</strong></p>";
		}else{
			
			foreach($arr_data as $arr){
				$addCart = "<a href='cart.php?productId=".$arr['id']."'><strong>+ Add to Cart</strong></a>";
				if(isset($_SESSION["signedin"]) && ($_SESSION["signedin"] == "yes") ){
					$addCart = "";
				}
				$returnedValue .="<a href='product.php?productId=".$arr['id']."'><h3>".$arr['title']." - ".$arr['color']." - ".$arr['type']."</h3></a>".$addCart;
				$returnedValue .="<a href='product.php?productId=".$arr['id']."'><img class='col-xs-4 col-sm-3 col-lg-2' src='data:image/png;base64,".base64_encode($arr['img1'])."'></a>";
				$returnedValue .="<p>".$arr['description']."</p>";
				$returnedValue .= "<div style='clear:both; margin-bottom:20px;'></div>";
			}
		}
		return $returnedValue;
	}
	public function VviewBrowse($arr_data){
		$returnedValue ="";
		if(empty($arr_data)){
			$returnedValue .="<p><strong>There were no results found</strong></p>";
		}else{
			foreach($arr_data as $arr){
				$addCart = " <a href='cart.php?productId=".$arr['id']."'><strong>+ Add to Cart</strong></a>";
				if(isset($_SESSION["signedin"]) && ($_SESSION["signedin"] == "yes") ){
					$addCart = "";
				}
				$returnedValue .="<a href='product.php?productId=".$arr['id']."'><h3>".$arr['title']." - ".$arr['color']." - ".$arr['type']."</h3></a> ".$addCart;
				$returnedValue .="<a href='product.php?productId=".$arr['id']."'><img class='col-xs-4 col-sm-3 col-lg-2' src='data:image/png;base64,".base64_encode($arr['img1'])."'></a>";
				$returnedValue .="<p>".$arr['description']."</p>";
				$returnedValue .= "<div style='clear:both; margin-bottom:20px;'></div>";
			}
		}
		return $returnedValue;
	}
	
	public function VviewCart(){
		$returnedValue ="";
		if(empty($_SESSION['cart'])){
			$returnedValue .="<p><strong>The cart is empty</strong></p>";
		}else{
		$total = 0;
		$productPreis =0;
		$returnedValue .= "<span style='float:right;'><a href='cart.php?empty=all'><strong>- Empty cart</strong></a></span>";
		$returnedValue .= "<div style='clear:both; margin-bottom:20px;'></div>";
		
		$returnedValue .="<table class='table table-bordered table-hover'>";
		$returnedValue .="<tr>";
			$returnedValue .="<th>Product</th>";
			$returnedValue .="<th>Price</th>";
			$returnedValue .="<th class='text-center'>Amount</th>";
			$returnedValue .="<th class='text-center'>Total Price</th>";
			$returnedValue .="<th class='text-center'></th>";
		$returnedValue .="</tr>";

		//$returnedValue .="<span  class='col-xs-5 noPadding cartBorder'><strong>Product</strong></span> <span class='col-xs-2 noPadding cartBorder'><strong>Preis</strong></span> <span class='col-xs-2 noPadding cartBorder'><strong>Amount</strong></span> <span class='col-xs-2 noPadding cartBorder'><strong>Total Preis</strong></span>";
			foreach($_SESSION['cart'] as $productId => $productValue){
				$productPreis = round($productValue['preis'] * $productValue['amount'],2);
				
				$returnedValue .="<tr>";
					$returnedValue .="<td><a class='col-xs-12 noPadding cartBorder' href='product.php?productId=".$productId."'><img class='col-xs-6 col-sm-3 col-md-2 noPadding' src='data:image/png;base64,".base64_encode($productValue['img1'])."'><span class='col-xs-6 col-sm-9 col-md-10'>".$productValue['title'].", ".$productValue['color'].", ".$productValue['type']." </span>  </a></td>";
					$returnedValue .="<td>".round($productValue['preis'],2)."</td>";
					$returnedValue .="<td class='text-center'>".$productValue['amount']."</td>";
					$returnedValue .="<td class='text-center'>".$productPreis."</td>";
					$returnedValue .="<td class='text-center'><a href='cart.php?emptyId=".$productId."'><strong>X</strong></a></td>";
				$returnedValue .="</tr>";

				/*
				$returnedValue .="<a class='col-xs-5 noPadding cartBorder' href='product.php?productId=".$productId."'><img class='col-xs-5 col-md-3 noPadding' src='data:image/png;base64,".base64_encode($productValue['img1'])."'><span class='col-xs-6'>".$productValue['title']." - ".$productValue['color']." - ".$productValue['type']." </span>  </a> <span class='col-xs-2 noPadding cartBorder'>".round($productValue['preis'],2)."</span> <span class='col-xs-2 noPadding cartBorder'>".$productValue['amount']."</span> <span class='col-xs-2 noPadding cartBorder'>".$productPreis."</span> <span class='col-xs-1 '><a href='cart.php?emptyId=".$productId."'><strong>X</strong></a></span>";
				$total = round($total + $productPreis,2) ;
				$returnedValue .= "<div style='clear:both; margin-bottom:20px;'></div>";*/
				$total = round($total + $productPreis,2) ;
			}
			$returnedValue .="<tr>";
				$returnedValue .="<td colspan='3'></td>";
				//$returnedValue .="<td></td>";
				//$returnedValue .="<td></td>";
				$returnedValue .="<td colspan='2'><strong>".$total." SYP</strong></td>";
				//$returnedValue .="<td></td>";
			$returnedValue .="</tr>";

			//$returnedValue .="<span class='col-xs-5 noPadding'></span> <span class='col-xs-2 noPadding'></span> <span class='col-xs-2 noPadding'></span> <span class='col-xs-2 noPadding cartBorder'><strong>".$total."</strong></span>";
		}
		$returnedValue .='</table>';
		return $returnedValue;
	}
	
	
	public function VviewOrders($arr_data2){
		$returnedValue ="";
		if(empty($arr_data2)){
			$returnedValue .="<p><strong>No orders found</strong></p>";
		}else{
			$i = 1;
			foreach ($arr_data2 as $arr){
				$returnedValue .="<h3>Order ".$i.":</h3>";
				$i++;
				$returnedValue .="<p><strong>Customer: </strong>".$arr['firstname']." ".$arr['lastname']."<br />";
				$returnedValue .="<strong>Address: </strong>".$arr['address']."<br />";
				$returnedValue .="<strong>Phone: </strong>".$arr['phone']."<br />";
				$hall = "Almalki hall";
				if($arr['hall']== 1){
					$hall = "Baghdaad Str. hall";
				}
				$returnedValue .="<strong>Hall: </strong>".$hall."<br />";
				$returnedValue .="<strong>appointment: </strong>".$arr['appointment']."</p><br />";
				
				$total = 0;
				$productPreis =0;

				$returnedValue .="<table class='table table-bordered table-hover'>";
					$returnedValue .="<tr>";
						$returnedValue .="<th>Product</th>";
						$returnedValue .="<th>Price</th>";
						$returnedValue .="<th class='text-center'>Amount</th>";
						$returnedValue .="<th class='text-center'>Total Price</th>";
					$returnedValue .="</tr>";
					
				foreach ($arr['cart'] as $productId => $productValue){
					
					$productPreis = round($productValue['preis'] * $productValue['amount'],2);
				
					$returnedValue .="<tr>";
						$returnedValue .="<td><a class='col-xs-12 noPadding cartBorder' href='product.php?productId=".$productId."'><img class='col-xs-6 col-sm-3 col-md-2 noPadding' src='data:image/png;base64,".base64_encode($productValue['img1'])."'><span class='col-xs-6 col-sm-9 col-md-10'>".$productValue['title'].", ".$productValue['color'].", ".$productValue['type']." </span>  </a></td>";
						$returnedValue .="<td>".round($productValue['preis'],2)."</td>";
						$returnedValue .="<td class='text-center'>".$productValue['amount']."</td>";
						$returnedValue .="<td class='text-center'>".$productPreis."</td>";
					$returnedValue .="</tr>";

					$total = round($total + $productPreis,2) ;
				}
				
				$returnedValue .="<tr>";
					$returnedValue .="<td colspan='3'></td>";
					$returnedValue .="<td><strong>".$total." SYP</strong></td>";
				$returnedValue .="</tr>";
				
			$returnedValue .='</table>';				
			}
			

		}
		return $returnedValue;
	}
}
?>