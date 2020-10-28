<?php

Class Database
{
	private $server;
    private $user;
    private $pass;
    private $db;
    private $lconn;
  
    public function __construct($server , $db , $user , $pass )
    {	
    	$this->server = $server;
    	$this->db =  $db;
        $this->user = $user ;
        $this->pass = $pass;
    }
    public function connectdb()
    {
    	$con = mysqli_connect($this->server,$this->user,$this->pass);
		mysqli_set_charset($con , "utf8");
		if(!$con)
		{
			die("Could not connect: ".mysqli_error($con));
			echo "error";
		}
		mysqli_select_db($con ,$this->db);
		mysqli_set_charset($con ,'utf8');
    	$this->lconn = $con; 	
     }
       
		
	
	public function DBGetReviews(){
		$sql = "select * from reviews;";
		
		$resultArr = $this->querydb($sql);
		return  $resultArr;

	}
	public function DBGetLiked(){
		$sql = "select count(liked) as total from reviews where liked = 1;";
		
		$resultArr = $this->querydb($sql);
		return  $resultArr[0];

	}
	public function DBGetRating(){
		$sql = "select avg(rate) as average from reviews;";
		
		$resultArr = $this->querydb($sql);
		return  $resultArr[0];

	}

	public function DBGetAuth(){
		$sql = "select * from account where username = '".htmlentities($_POST['username'], ENT_QUOTES)."' and password = '".md5($_POST['password'])."';";
		
		$resultArr = $this->querydb($sql);
		if(empty($resultArr)){
			return false;
		}else{
			return true;
		}
	}
	
	public function DBAddReview($liked ,$rate){
	
		$sql = "INSERT INTO reviews 
				(name,messege,liked,rate) 
                VALUES ('".htmlentities($_POST['name'], ENT_QUOTES)."', '".htmlentities($_POST['message'], ENT_QUOTES)."', ".$liked.", ".$rate." );";

		$stmt = mysqli_query($this->lconn ,$sql);
		if( $stmt === false ) {
		     die( print_r( mysqli_error($this->lconn), true));
		 }
	
	}
	public function DBAddProduct(){
		$image1 = NULL;
		$image2 = NULL;
		$image3 = NULL;
		$image4 = NULL;

		if (file_exists($_FILES['img1']['tmp_name']) && is_uploaded_file($_FILES['img1']['tmp_name'])){
			$image1 = addslashes(file_get_contents($_FILES['img1']['tmp_name'])); //SQL Injection defence!
		}
		
		if (file_exists($_FILES['img2']['tmp_name']) && is_uploaded_file($_FILES['img2']['tmp_name'])){
			$image2 = addslashes(file_get_contents($_FILES['img2']['tmp_name'])); //SQL Injection defence!
		}
		
		if (file_exists($_FILES['img3']['tmp_name']) && is_uploaded_file($_FILES['img3']['tmp_name'])){
			$image3 = addslashes(file_get_contents($_FILES['img3']['tmp_name'])); //SQL Injection defence!
		}
		
		if (file_exists($_FILES['img4']['tmp_name']) && is_uploaded_file($_FILES['img4']['tmp_name'])){
			$image4 = addslashes(file_get_contents($_FILES['img4']['tmp_name'])); //SQL Injection defence!
		}
		
		$sql = "INSERT INTO products 
				(title,type,color,preis,img1,img2,img3,img4,description) 
                VALUES ('".htmlentities($_POST['title'], ENT_QUOTES)."', '".htmlentities($_POST['type'], ENT_QUOTES)."', '".htmlentities($_POST['color'], ENT_QUOTES)."', '".htmlentities($_POST['preis'], ENT_QUOTES)."','".$image1."', '".$image2."', '".$image3."', '".$image4."', '".htmlentities($_POST['description'], ENT_QUOTES)."');";

		$stmt = mysqli_query($this->lconn ,$sql);
		if( $stmt === false ) {
		     die( print_r( mysqli_error($this->lconn), true));
		}else{
			return true;
		}
	}
	public function DBGetProduct($ProductId){
		$sql = "select * from products where id = ".$ProductId.";";
		$resultArr = $this->querydb($sql);
		return  $resultArr[0];

	}
	public function DBGetSearch($term){
		$sql = "select * from products where title like '%".htmlentities($term, ENT_QUOTES)."%' or  type like  '%".htmlentities($term, ENT_QUOTES)."%' or color like  '%".htmlentities($term, ENT_QUOTES)."%' or description like  '%".htmlentities($term, ENT_QUOTES)."%';";
		$resultArr = $this->querydb($sql);
		return  $resultArr;
	}
	
	public function DBGetBrowse(){
		$sql = "select * from products order by id;";
		$resultArr = $this->querydb($sql);
		return  $resultArr;
	}
	
	public function DBAddCustomerCart(){
		//date("Y-m-d H:i:s", strtotime($_POST["appointment"]))
		$sql = "INSERT INTO customer 
				(firstname,lastname,address,phone,hall,appointment) 
                VALUES ( '".htmlentities($_POST['firstname'], ENT_QUOTES)."', '".htmlentities($_POST['lastname'], ENT_QUOTES)."', '".htmlentities($_POST['address'], ENT_QUOTES)."', '".htmlentities($_POST['phone'], ENT_QUOTES)."', ".$_POST['hall'].",  '".date('Y-m-d H:i:s', strtotime($_POST['appointment']))."');";
        
        $stmt = mysqli_query($this->lconn ,$sql);
		if( $stmt === false ) {
		     die( print_r( mysqli_error($this->lconn), true));
		}
		
		$sql = "SELECT LAST_INSERT_ID() as id;";
		$resultArr = $this->querydb($sql);
		
		foreach($_SESSION['cart'] as $productId => $productValue){
		      
    	    $sql =  " INSERT INTO `customer_order`
    	    (`customer_id`, `product_id`, `price`, `amount`) 
                VALUES (".$resultArr[0]['id'].", ".$productId." , '".round($productValue['preis'],2)."' , ".$productValue['amount']."); ";
			$stmt = mysqli_query($this->lconn ,$sql);
			if( $stmt === false ) {
			     die( print_r( mysqli_error($this->lconn), true));
			}
		}
		return true;
		
	}
		
	public function DBGetOrders(){
		$sql = "select * from customer;";
		$resultArr = $this->querydb($sql);
		
		
		$sql2 = "select * from customer_order;";
		$resultArr2 = $this->querydb($sql2);
		$i = 0;
		foreach($resultArr as $key => $arr){
			$alt_customer_id = $resultArr2[$i]['customer_id'];
			while ($i < count($resultArr2) && $resultArr2[$i]['customer_id'] == $alt_customer_id){
				$resultArr[$key]['cart'][$resultArr2[$i]['product_id']]['amount'] = $resultArr2[$i]['amount'];
				$resultArr[$key]['cart'][$resultArr2[$i]['product_id']]['preis'] = $resultArr2[$i]['price'];
				$i++;
				
			}
			
		}
		return  $resultArr;
	}
	
	
	public function DBCompleteGetOrders($arr_data){
		foreach($arr_data as $key1 => $arr){
			foreach($arr['cart'] as $key2 => $val){
				$product = $this->DBGetProduct($key2);
				$arr_data[$key1]['cart'][$key2]['title'] = $product['title'];
				$arr_data[$key1]['cart'][$key2]['color'] = $product['color'];
				$arr_data[$key1]['cart'][$key2]['type'] = $product['type'];
				$arr_data[$key1]['cart'][$key2]['img1'] = $product['img1'];
			}
		}
		return $arr_data;
	}
	
    function querydb($sql) {
	
	
		$stmt = mysqli_query($this->lconn ,$sql);
		$StmtArr = array();
		if( $stmt === false ) {
			die( print_r( mysqli_error($this->lconn), true));
		} else {
			while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC))
			{
				$StmtArr[]	= $row;

			}
		}
		return $StmtArr;
			
	}

    public function disconnectdb() {
    	@mysqli_close($this->lconn);           
   	}
}


?>