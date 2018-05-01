<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Role.php");
    ob_clean();

	class PostageConfig extends Table
	{
	    function PostageConfig($myMySQL, $table = "postage_config")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getData($row)
        {
            $dataArray = array();
            $dataArray['{no}']              = $row['no'];
            $dataArray['{first_weight}']    = $row['first_weight'];  //单位千克
            $dataArray['{first_price}']     = $row['first_price']/100;    //单位分,展示元
            $dataArray['{continue_weight}'] = $row['continue_weight'];
            $dataArray['{continue_price}']  = $row['continue_price']/100;
            $dataArray['{province}']        = $row['province'];
            $dataArray['{city}']            = $row['city'];
            $dataArray['{district}']        = $row['district'];
            $dataArray['{add_time}']        = $row['add_time'];
            $dataArray['{update_time}']     = $row['update_time'];

            return $dataArray;
        }

	}

?>