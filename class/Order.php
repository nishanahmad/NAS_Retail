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
        $query = "select * FROM nas_sale WHERE ar_id = ? AND ar_direct = 1 AND entry_date >= '$today'";
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

    function insertOrder($entry_date,$product,$qty,$ar_id,$customer_name,$customer_phone,$address1,$remarks,$godown,$entered_by,$entered_on)
    {
		$ar_direct = 1;
        $query = "INSERT INTO nas_sale (entry_date,product,qty,ar_id,customer_name,customer_phone,address1,remarks,ar_direct,godown,entered_by,entered_on) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $paramType = "siiissssiiss";
        $paramArray = array($entry_date,$product,$qty,$ar_id,$customer_name,$customer_phone,$address1,$remarks,$ar_direct,$godown,$entered_by,$entered_on);
        $result = $this->ds->insert($query, $paramType, $paramArray);
        
        return $result;
    }	
}