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
        $query = "select * FROM nas_sale WHERE ar_id = ? AND direct_order = 1 AND entry_date >= '$today'";
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
        $query = "select * FROM godowns WHERE name != 'KAKKAD' AND name != 'MUTTOM' AND name != 'VARAM'";
        $godowns = $this->ds->select($query);
        
        return $godowns;
    }

    function insertOrder($entry_date,$product,$qty,$ar_id,$customer_name,$customer_phone,$address1,$pin,$remarks,$godown,$entered_by,$entered_on)
    {
		$direct_order = 1;
		$address1 = $address1.' - PIN : '.$pin;
        $query = "INSERT INTO nas_sale (entry_date,product,qty,ar_id,customer_name,customer_phone,address1,remarks,direct_order,godown,entered_by,entered_on) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $paramType = "siiissssiiss";
        $paramArray = array($entry_date,$product,$qty,$ar_id,$customer_name,$customer_phone,$address1,$remarks,$direct_order,$godown,$entered_by,$entered_on);
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