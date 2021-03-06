<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Role.php");
    ob_clean();

	class Search extends Table
	{
	    function Search($myMySQL, $table = "search")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getData($row)
        {
            $dataArray = array();
            $dataArray['{no}']          = $row['no'];
            $dataArray['{user_no}']     = $row['user_no'];
            $dataArray['{title}']       = $row['title'];
            $dataArray['{add_time}']    = $row['add_time'];
            $dataArray['{update_time}'] = $row['update_time'];
            $dataArray['{is_display}']  = $row['is_display'];

            return $dataArray;
        }

        function getDataClean($row)
        {
            $dataArray = array();
            $dataArray['no']          = $row['no'];
            $dataArray['user_no']     = $row['user_no'];
            $dataArray['title']       = $row['title'];
            $dataArray['add_time']    = $row['add_time'];
            $dataArray['update_time'] = $row['update_time'];
            $dataArray['is_display']  = $row['is_display'];

            return $dataArray;
        }
	}

?>