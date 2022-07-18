<?php
namespace Phppot;

use \Phppot\NASConnect;
use \Phppot\DataSource;

class Order
{

    private $dbConn;

    private $ds;

    function __construct()
    {
        require_once "NASConnect.php";
        $this->ds = new NASConnect();
    }

    function getOrders($memberId)
    {
		$today = date('Y-m-d');
        $query = "select * FROM nas_sale WHERE ar_id = ? AND entry_date >= '$today' ORDER BY direct_order DESC";
        $paramType = "i";
        $paramArray = array($memberId);
        $memberResult = $this->ds->select($query, $paramType, $paramArray);
        
        return $memberResult;
    }
	
    function getProducts()
    {
        $query = "select * FROM products";
        $products = $this->ds->select($query);
        
        return $products;
    }	
	
    function getGodowns()
    {
		$godownMap = array();
        $query = "select * FROM godowns WHERE name != 'KAKKAD' AND name != 'MUTTOM' AND name != 'VARAM'";
        $godowns = $this->ds->select($query);
		foreach($godowns as $godown)
			$godownMap[$godown['id']] = $godown['name'];
        
        return $godownMap;
    }
	
    function getTrucks()
    {
		$truckMap = array();
        $query = "select * FROM truck_details WHERE number='LORRY' OR number='TEMPO' OR number='NISSAN' OR number='MINI EICHER' OR number='EICHER'";
        $trucks = $this->ds->select($query);
		foreach($trucks as $truck)
			$truckMap[$truck['id']] = $truck['number'];
        
        return $truckMap;
    }	

    function insertOrder($entry_date,$product,$qty,$ar_id,$customer_name,$customer_phone,$address1,$pin,$truck,$remarks,$godown,$entered_by,$entered_on,$ar_direct)
    {
		$direct_order = 1;
		if(!empty($pin))
			$address1 = $address1.' - PIN : '.$pin;
        $query = "INSERT INTO nas_sale (entry_date,product,qty,ar_id,customer_name,customer_phone,address1,truck,remarks,direct_order,godown,entered_by,entered_on,ar_direct) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $paramType = "siiisssisiissi";
        $paramArray = array($entry_date,$product,$qty,$ar_id,$customer_name,$customer_phone,$address1,$truck,$remarks,$direct_order,$godown,$entered_by,$entered_on,$ar_direct);
        $result = $this->ds->insert($query, $paramType, $paramArray);
        
		return $result;
    }

    function deleteOrder($id)
    {
        $query = "DELETE FROM nas_sale WHERE sales_id = ?";
        $paramType = "i";
        $paramArray = array($id);
        $result = $this->ds->deleteCommand($query, $paramType, $paramArray);
        
        return $result;
    }	
}