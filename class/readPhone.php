<?php
class DBController {
	private $host = "localhost";
	private $user = "nishan";
	private $password = "darussalam123.";
	private $database = "nas";
	private $conn;
	
	function __construct() {
		$this->conn = $this->connectDB();
	}
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
	function runQuery($query) {
		$result = mysqli_query($this->conn,$query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = mysqli_query($this->conn,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
}

$db_handle = new DBController();
if(!empty($_POST["keyword"])) 
{
	$query ="SELECT DISTINCT customer_phone FROM nas_sale WHERE customer_phone like '" . $_POST["keyword"] . "%' ORDER BY customer_phone LIMIT 0,6";
	$result = $db_handle->runQuery($query);
	if(!empty($result)) 
	{																															?>
		<ul id="country-list">																									<?php
			foreach($result as $sale) 
			{																														?>
				<li onClick="selectPhone('<?php echo $sale["customer_phone"]; ?>');"><?php echo $sale["customer_phone"]; ?></li><?php 
			} 																													  ?>
		</ul>																													<?php 
	} 
} 																																?>
