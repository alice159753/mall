<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Role.php");
    ob_clean();

	class Brand extends Table
	{
	    function Brand($myMySQL, $table = "brand")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getIsShow()
        {
            return array('Y' => '是', 'N' => '否');
        }

        function getData($row)
        {
            $isShowMap = $this->getIsShow();

            $dataArray = array();
            $dataArray['{no}']            = $row['no'];
            $dataArray['{title}']         = $row['title'];
            $dataArray['{site_url}']      = $row['site_url'];
            $dataArray['{add_time}']      = $row['add_time'];
            $dataArray['{update_time}']   = $row['update_time'];
            $dataArray['{is_show}']       = $row['is_show'];
            $dataArray['{is_show_title}'] = $isShowMap[ $row['is_show'] ];
            $dataArray['{sort}']          = $row['sort'];
            $dataArray['{description}']   = $row['description'];
            $dataArray['{pic}']           = $row['pic'];

            $dataArray['{show_checkbox}'] = $row['is_show'] == 'Y' ? 'checked' : '';

            return $dataArray;
        }

        function getDataClean($row)
        {
            $isShowMap = $this->getIsShow();

            $dataArray = array();
            $dataArray['no']            = $row['no'];
            $dataArray['title']         = $row['title'];
            $dataArray['site_url']      = $row['site_url'];
            $dataArray['add_time']      = $row['add_time'];
            $dataArray['update_time']   = $row['update_time'];
            $dataArray['is_show']       = $row['is_show'];
            $dataArray['is_show_title'] = $isShowMap[ $row['is_show'] ];
            $dataArray['sort']          = $row['sort'];
            $dataArray['description']   = $row['description'];
            $dataArray['pic']           = $row['pic'];

            $dataArray['show_checkbox'] = $row['is_show'] == 'Y' ? 'checked' : '';

            return $dataArray;
        }
	}

?>