<?php
namespace Phppot;

use \Phppot\NASConnect;

require_once "NASConnect.php";
$db_handle = new NASConnect();

session_start();
$arId = $_SESSION["userId"];

if(!empty($_POST["keyword"])) 
{
	$query ="SELECT DISTINCT customer_phone FROM nas_sale WHERE ar_id=$arId AND customer_phone like '" . $_POST["keyword"] . "%' ORDER BY customer_phone LIMIT 0,6";
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
