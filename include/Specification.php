<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Role.php");
    ob_clean();

	class Specification extends Table
	{
	    function Specification($myMySQL, $table = "specification")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getData($row)
        {
            $dataArray = array();
            $dataArray['{no}']          = $row['no'];
            $dataArray['{title}']       = $row['title'];
            $dataArray['{content}']     = $row['content'];
            $dataArray['{add_time}']    = $row['add_time'];
            $dataArray['{update_time}'] = $row['update_time'];

            return $dataArray;
        }

        function getDataClean($row)
        {
            $dataArray = array();
            $dataArray['no']          = $row['no'];
            $dataArray['title']       = $row['title'];
            $dataArray['content']     = $row['content'];
            $dataArray['add_time']    = $row['add_time'];
            $dataArray['update_time'] = $row['update_time'];

            return $dataArray;
        }
	}

?>