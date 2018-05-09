<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Role.php");
    ob_clean();

	class UserCardsRecord extends Table
	{
	    function UserCardsRecord($myMySQL, $table = "user_cards_record")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getIsDefault()
        {
            return array('1' => '是', '0' => '否');
        }

        function getData($row)
        {
            $isDefaultMap = $this->getIsDefault();

            $dataArray = array();
            $dataArray['{no}']               = $row['no'];
            $dataArray['{user_no}']          = $row['user_no'];
            $dataArray['{user_cards_no}']    = $row['user_cards_no'];
            $dataArray['{cards_sn}']         = $row['cards_sn'];
            $dataArray['{is_default}']       = $row['is_default'];
            $dataArray['{add_time}']         = $row['add_time'];
            $dataArray['{update_time}']      = $row['update_time'];
            $dataArray['{is_default_title}'] = $isDefaultMap[ $row['is_default'] ];

    
            return $dataArray;
        }

        function getDataClean($row)
        {
            $isDefaultMap = $this->getIsDefault();

            $dataArray = array();
            $dataArray['no']               = $row['no'];
            $dataArray['user_no']          = $row['user_no'];
            $dataArray['user_cards_no']    = $row['user_cards_no'];
            $dataArray['cards_sn']         = $row['cards_sn'];
            $dataArray['is_default']       = $row['is_default'];
            $dataArray['add_time']         = $row['add_time'];
            $dataArray['update_time']      = $row['update_time'];
            $dataArray['is_default_title'] = $isDefaultMap[ $row['is_default'] ];

            return $dataArray;
        }
	}

?>