<?php

	include_once("Table.php");

	class UserFootPrint extends Table
	{
	    function UserFootPrint($myMySQL, $table = "user_footprint")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getData($row)
        {
            $dataArray = array();
            $dataArray["{no}"]          = $row['no'];
            $dataArray["{user_no}"]     = $row['user_no'];
            $dataArray["{product_no}"]  = $row['product_no'];
            $dataArray["{add_time}"]    = $row['add_time'];
            $dataArray['{update_time}'] = $row['update_time'];

            return $dataArray;
        }

        function getDataClean($row)
        {
            $dataArray = array();
            $dataArray["no"]          = $row['no'];
            $dataArray["user_no"]     = $row['user_no'];
            $dataArray["product_no"]  = $row['product_no'];
            $dataArray["add_time"]    = $row['add_time'];
            $dataArray['update_time'] = $row['update_time'];

            return $dataArray;
        }

	}

?>