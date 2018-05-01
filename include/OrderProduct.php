<?php

	include_once("Table.php");

    ob_start();
    ob_clean();

	class OrderProduct extends Table
	{
	    function OrderProduct($myMySQL, $table = "order_product")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getData($row)
        {
            $dataArray = array();
            $dataArray['{no}']              = $row['no'];
            $dataArray['{user_no}']         = $row['user_no'];
            $dataArray['{order_no}']        = $row['order_no'];
            $dataArray['{order_sn}']        = $row['order_sn'];
            $dataArray['{product_no}']      = $row['product_no'];
            $dataArray['{product_title}']   = $row['product_title'];
            $dataArray['{product_pic}']     = $row['product_pic'];
            $dataArray['{product_weight}']  = $row['product_weight'];
            $dataArray['{shop_price}']      = $row['shop_price'] / 100;
            $dataArray['{market_price}']    = $row['market_price'] / 100;
            $dataArray['{buy_num}']         = $row['buy_num'];
            $dataArray['{add_time}']        = $row['add_time'];
            $dataArray['{add_time}']        = $row['add_time'];
            $dataArray['{update_time}']     = $row['update_time'];
            $dataArray['{channel_id}']      = $row['channel_id'];
            $dataArray['{total_fee}']       = $row['shop_price'] * $row['buy_num'] /100;
            $dataArray['{product_attr_no}'] = $row['product_attr_no'];

            return $dataArray;
        }


	}

?>