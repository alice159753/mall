<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Category.php");
    ob_clean();
    

	class ProductAttr extends Table
	{
	    function ProductAttr($myMySQL, $table = "product_attr")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getData($row)
        {
            $dataArray = array();
            $dataArray['{no}']             = $row['no'];
            $dataArray['{product_no}']     = $row['product_no'];
            $dataArray['{title}']          = $row['title'];
            $dataArray['{img_url}']        = $row['img_url'];
            $dataArray['{price}']          = $row['price'] / 100;
            $dataArray['{add_time}']       = $row['add_time'];
            $dataArray['{update_time}']    = $row['update_time'];
            $dataArray['{product_weight}'] = $row['product_weight'];

            return $dataArray;
        }

	}

   

?>