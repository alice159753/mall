<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Role.php");
    ob_clean();

	class DiscountCouponRecord extends Table
	{
	    function DiscountCouponRecord($myMySQL, $table = "discount_coupon_record")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getIsUse()
        {
            return array('1' => '是', '0' => '否');
        }

        function getIsPast()
        {
            return array('1' => '是', '0' => '否');
        }

        function getData($row)
        {
            $isUseMap = $this->getIsUse();
            $isPastMap = $this->getIsPast();

            $dataArray = array();
            $dataArray['{no}']                 = $row['no'];
            $dataArray['{user_no}']            = $row['user_no'];
            $dataArray['{discount_coupon_no}'] = $row['discount_coupon_no'];
            $dataArray['{add_time}']           = $row['add_time'];
            $dataArray['{update_time}']        = $row['update_time'];
            $dataArray['{is_use_title}']       = $isUseMap[ $row['is_use'] ];
            $dataArray['{is_past_title}']      = $isPastMap[ $row['is_past'] ];
            $dataArray['{is_use}']             = $row['is_use'];
            $dataArray['{is_past}']            = $row['is_past'];

            return $dataArray;
        }

        function getDataClean($row)
        {
            $isUseMap = $this->getIsUse();
            $isPastMap = $this->getIsPast();

            $dataArray = array();
            $dataArray['no']                 = $row['no'];
            $dataArray['user_no']            = $row['user_no'];
            $dataArray['discount_coupon_no'] = $row['discount_coupon_no'];
            $dataArray['add_time']           = $row['add_time'];
            $dataArray['update_time']        = $row['update_time'];
            $dataArray['is_use_title']       = $isUseMap[ $row['is_use'] ];
            $dataArray['is_past_title']      = $isPastMap[ $row['is_past'] ];
            $dataArray['is_use']             = $row['is_use'];
            $dataArray['is_past']            = $row['is_past'];

            return $dataArray;
        }
	}

?>