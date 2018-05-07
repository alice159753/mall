<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Role.php");
    ob_clean();

	class UserLabel extends Table
	{
	    function UserLabel($myMySQL, $table = "user_label")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getData($row)
        {
            $dataArray = array();
            $dataArray['{no}']            = $row['no'];
            $dataArray['{title}']         = $row['title'];
            $dataArray['{add_time}']      = $row['add_time'];
            $dataArray['{update_time}']   = $row['update_time'];
            $dataArray['{pay_num}']       = $row['pay_num'];
            $dataArray['{consume_price}'] = $row['consume_price'];
            $dataArray['{integral}']      = $row['integral'];

            return $dataArray;
        }

        function getDataClean($row)
        {
            $dataArray = array();
            $dataArray['no']            = $row['no'];
            $dataArray['title']         = $row['title'];
            $dataArray['add_time']      = $row['add_time'];
            $dataArray['update_time']   = $row['update_time'];
            $dataArray['pay_num']       = $row['pay_num'];
            $dataArray['consume_price'] = $row['consume_price'];
            $dataArray['integral']      = $row['integral'];

            return $dataArray;
        }
	}

?>