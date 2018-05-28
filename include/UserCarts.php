<?php

	include_once("Table.php");

	class UserCarts extends Table
	{
	    function UserCarts($myMySQL, $table = "user_carts")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getDataClean($row)
        {
            $dataArray = array();
            $dataArray['no']                = $row['no'];
            $dataArray['user_no']           = $row['user_no'];
            $dataArray['product_no']        = $row['product_no'];
            $dataArray['product_title']     = $row['product_title'];
            $dataArray['product_pic']       = FILE_URL.$row['product_pic'];
            $dataArray['sale_price']        = $row['sale_price'];
            $dataArray['lineation_price']   = $row['lineation_price'];
            $dataArray['member_price']      = $row['member_price'];
            //$dataArray['cost_price']        = $row['cost_price'];
            $dataArray['buy_num']           = $row['buy_num'];
            $dataArray['product_attr_no']   = $row['product_attr_no'];
            $dataArray['product_attr_text'] = $row['product_attr_text'];
            $dataArray['product_weight_kg'] = $row['product_weight_kg'];
            $dataArray['product_weight_g']  = $row['product_weight_g'];
            $dataArray['add_time']          = $row['add_time'];
            $dataArray['update_time']       = $row['update_time'];

            return $dataArray;
        }

	}

?>