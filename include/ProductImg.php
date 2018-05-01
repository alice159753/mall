<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Category.php");
    ob_clean();
    

	class ProductImg extends Table
	{
	    function ProductImg($myMySQL, $table = "product_img")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getData($row)
        {
            $dataArray = array();
            $dataArray['{no}']          = $row['no'];
            $dataArray['{product_no}']  = $row['product_no'];
            $dataArray['{img_url}']     = $row['img_url'];
            $dataArray['{thumb_url}']   = $row['thumb_url'];
            $dataArray['{img_desc}']    = $row['img_desc'];
            $dataArray['{add_time}']    = $row['add_time'];
            $dataArray['{update_time}'] = $row['update_time'];

            return $dataArray;
        }

	}

   

?>