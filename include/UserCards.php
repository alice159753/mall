<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Role.php");
    ob_clean();

	class UserCards extends Table
	{
	    function UserCards($myMySQL, $table = "user_cards")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getIsShipping()
        {
            return array('1' => '是', '2' => '否');
        }

        function getIsDiscount()
        {
            return array('1' => '是', '2' => '否');
        }

        function getIsGiveIntegral()
        {
            return array('1' => '是', '2' => '否');
        }

        function getDateType()
        {
            return array('1' => '无限期', '2' => '$$天', '3'=>'固定日期: start~end');
        }

        function getData($row)
        {

            $isShippingMap = $this->getIsShipping();
            $isDiscountMap = $this->getIsDiscount();
            $isGiveIntegralMap = $this->getIsGiveIntegral();
            $dateTypeMap = $this->getDateType();

            $dataArray = array();
            $dataArray['{no}']               = $row['no'];
            $dataArray['{title}']            = $row['title'];
            $dataArray['{is_shipping}']      = $row['is_shipping'];
            $dataArray['{is_discount}']      = $row['is_discount'];
            $dataArray['{discount}']         = $row['discount'];
            $dataArray['{is_give_integral}'] = $row['is_give_integral'];
            $dataArray['{give_integral}']    = $row['give_integral'];
            $dataArray['{note}']             = $row['note'];
            $dataArray['{date_type}']        = $row['date_type'];
            $dataArray['{day}']              = $row['day'];
            $dataArray['{start_date}']       = $row['start_date'];
            $dataArray['{end_date}']         = $row['end_date'];
            $dataArray['{add_time}']         = $row['add_time'];
            $dataArray['{update_time}']      = $row['update_time'];

            $dataArray['{is_shipping_title}']      = $row['is_shipping'] == 1 ? '包邮' : '';
            $dataArray['{is_discount_title}']      = $row['is_discount'] == 1 ? '打'.$row['discount'].'折' : '';
            $dataArray['{is_give_integral_title}'] = $row['is_give_integral'] == 1 ? '赠送'.$row['give_integral'].'积分' : '';
            $dataArray['{date_type_title}']        = $dateTypeMap[ $row['date_type'] ];

            if(  $row['date_type'] == 3 )
            {
                $dataArray['{date_type_title}'] = str_replace("start", $row['start_date'], $dataArray['{date_type_title}']);
                $dataArray['{date_type_title}'] = str_replace("end", $row['end_date'], $dataArray['{date_type_title}']);
            }

            if(  $row['date_type'] == 2 )
            {
                $dataArray['{date_type_title}'] = str_replace("$$", $row['day'], $dataArray['{date_type_title}']);
            }

            return $dataArray;
        }

        function getDataClean($row)
        {
            $isShippingMap = $this->getIsShipping();
            $isDiscountMap = $this->getIsDiscount();
            $isGiveIntegralMap = $this->getIsGiveIntegral();
            $dateTypeMap = $this->getDateType();

            $dataArray = array();
            $dataArray['no']               = $row['no'];
            $dataArray['title']            = $row['title'];
            $dataArray['is_shipping']      = $row['is_shipping'];
            $dataArray['is_discount']      = $row['is_discount'];
            $dataArray['discount']         = $row['discount'];
            $dataArray['is_give_integral'] = $row['is_give_integral'];
            $dataArray['give_integral']    = $row['give_integral'];
            $dataArray['note']             = $row['note'];
            $dataArray['date_type']        = $row['date_type'];
            $dataArray['day']              = $row['day'];
            $dataArray['start_date']       = $row['start_date'];
            $dataArray['end_date']         = $row['end_date'];
            $dataArray['add_time']         = $row['add_time'];
            $dataArray['update_time']      = $row['update_time'];

            $dataArray['is_shipping_title']      = $isShippingMap[ $row['is_shipping'] ];
            $dataArray['is_discount_title']      = $isDiscountMap[ $row['is_discount'] ];
            $dataArray['is_give_integral_title'] = $isGiveIntegralMap[ $row['is_give_integral'] ];
            $dataArray['date_type_title']        = $dateTypeMap[ $row['date_type'] ];

            if(  $row['date_type'] == 3 )
            {
                $dataArray['date_type_title'] = str_replace("start", $row['start_date'], $dataArray['date_type_title']);
                $dataArray['date_type_title'] = str_replace("end", $row['end_date'], $dataArray['date_type_title']);
            }

            if(  $row['date_type'] == 2 )
            {
                $dataArray['date_type_title'] = str_replace("$$", $row['day'], $dataArray['date_type_title']);
            }

            return $dataArray;
        }
	}

?>